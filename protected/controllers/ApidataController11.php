<?php

class ApidataController extends CController
{
 public function actionIndex()
 {
     $this->render("index");
 }
public function actionApdata1()
{
	$cl=$_GET["claimno"];
	$sql="SELECT * ,'1' AS `status`,'สาขาตั้งเรื่องเคลม' AS stepname,docauthorid AS per_id,docauthor AS p_name,claimdate AS c_date, docbranch AS br FROM claimdoc WHERE claimno = '$cl'
			UNION
			SELECT *,'2' AS `status`,'แผนกเคลมรับสินค้า' AS stepname,authorid3 AS per_id,authorname3 AS p_name,authordate3 AS c_date ,'23' AS br FROM claimdoc WHERE claimno = '$cl'
			UNION
			SELECT *,'3' AS `status`,'ส่งไปเคลม SUPPLIER' AS stepname,authorid4 AS per_id,authorname4 AS p_name,authordate4 AS c_date,'23' AS br FROM claimdoc WHERE claimno = '$cl'
			UNION
			SELECT *,'4' AS `status`,'แผนกเคลมรับสินค้ากลับจาก SUPPLIER' AS stepname,authorid6 AS per_id,authorname6 AS p_name,authordate6 AS c_date,'23' AS br FROM claimdoc WHERE claimno = '$cl'
			UNION
			SELECT *,'5' AS `status`,'ช่างเทคนิคทดสอบสินค้า' AS stepname,authorid7 AS per_id,authorname7 AS p_name,authordate7 AS c_date,'23' AS br FROM claimdoc WHERE claimno = '$cl' /*รับสินค้าคืนจาก Supplier*/
			UNION
			SELECT *,'6' AS `status`,'Packing เตรียมจัดส่งสินค้ากลับสาขา' AS stepname,authorid8 AS per_id,authorname8 AS p_name,authordate8 AS c_date,'23' AS br FROM claimdoc WHERE claimno = '$cl' /*ทดสอบสินค้าจาก Supplier*/
			UNION
			SELECT *,'7' AS `status`,'สาขารับสินค้าแล้ว' AS stepname,authorid9 AS per_id,authorname9 AS p_name,authordate9 AS c_date,branchrec AS br FROM claimdoc WHERE claimno = '$cl' /*รายการเคลมที่คืนสาขา */
			UNION
			SELECT *,'8' AS `status`,'ปิด JOB ส่งสินค้าคืนลูกค้าแล้ว' AS stepname,authorid10 AS per_id,authorname10 AS p_name,authordate10 AS c_date, branchrec AS br FROM claimdoc WHERE claimno = '$cl'

			";
	$job=Yii::app()->claim->createCommand($sql)->queryAll();
	$records=array();
	$result=array();
	$data=array();
	foreach ($job as $key=>$r) {
	$date_job=substr($r['c_date'], 0, 10);
	$authordate2=substr($r['authordate2'], 0, 10);
	if($date_job=='0000-00-00'){
		$c_date = '-';
	}else{
		$c_date = MyClass::monthThaiFull($date_job);
	}
	$chkname = "SELECT branchname FROM branch WHERE branch='" . $r["br"] . "'";
	$br = Yii::app()->jib->createCommand($chkname)->queryRow();
$st=null;
	if($r['docstatus']==1 or $r['docstatus']==2){
		$st=1;
	}else if($r['docstatus']==3 or $r['docstatus']==4){
		$st=2;
	}else if($r['docstatus']==5){
		$st=3;
	}else if($r['docstatus']==6 or $r['docstatus']==7){
		$st=4;
	}else if($r['docstatus']==8){
		$st=5;
	}else if($r['docstatus']==9){
		$st=6;
	}else if($r['docstatus']==10){
		$st=7;
	}else if ($r['docstatus']==11) {
		$st=8;
	}else if ($r['docstatus']==12 or $r['docstatus']==13 or $r['docstatus']==14 ) {
		$st=3;
	}
	if($r['type_pcode']==1){
		$tp='ไปรษณีย์';
	}else if($r['type_pcode']==2){
		$tp='kerry';
	}else{
		$tp='';
	}

	if($tp==''){
		$type_post="";
	}else{
		$type_post=$r['postcode'];
	}

	if($r['status']==3){
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>$br['branchname'],
			'suppliername'=>$r['suppliername'],
			'JOB SUP'=>$r['jobsup'],
			'details'=>$r['st_docdetail']
		);
	}else if($r['status']==8){
		$txt=null;
		if($r['type_pcode']!=''){
			$txt='ส่งสินค้าคืนลูกค้าทางไปรษณีย์';
		}
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>$br['branchname'],
			'suppliername'=>$r['suppliername'],
			'details'=>$txt,
			'type_post'=>$r['type_pcode'],
			'type_name'=>$tp,
			'postcode'=>$type_post
				);
	}else{
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>$br['branchname'],
			'suppliername'=>$r['suppliername']
		);
	}
		
	}
	$data[]=array(
    			'claimno'=>$r['claimno'],
    			'firstname'=>$r['firstname'],
				'lastname'=>$r['lastname'],
				'claimname'=>$r['claimname'],
				'custtel'=>$r['custtel'],
				'claimdate'=>MyClass::monthThaiFull($r['claimdate']),
				'docstatus'=>$st,
    			'result'=>$records
    		);
		echo json_encode($data);
}

public function actionApdata2()
{
	$claimno=$_GET["claimno"];
	$name=$_GET["name"];
	$custtel=$_GET["custtel"];

	$sql="SELECT claimno,firstname,lastname,custtel,claimname FROM claimdoc WHERE docstatus!=0  ";

	if($claimno=='' AND $name=='' AND $custtel==''){
		 $sql.=" AND (claimno = 'null' ) ";
	}

	if (!empty($claimno)) {
	        $sql.=" AND (claimno = '".$claimno."' ) ";
	}
	if (!empty($name)) {
	        $sql.=" AND (firstname LIKE '%" . $name . "%' OR lastname LIKE '%" . $name . "%' ) ";
	}
	if (!empty($custtel)) {
	        $sql.=" AND (custtel = '".$custtel."' ) ";
	}

	$res_claim=Yii::app()->claim->createCommand($sql)->queryAll();
	$data=array();

	foreach ($res_claim as $key=>$r) {
		$data[]=array(
				'claimno'=>$r['claimno'],
    			'cus_name'=>$r['firstname'].' '.$r['lastname'],
				'claimname'=>$r['claimname'],
				'custtel'=>$r['custtel'],

			);
	}
	echo json_encode($data);

}

public function actionProductnot75()
{
		$str="SELECT R.*,c.classname,IFNULL((SELECT IFNULL(SUM(sto),0) FROM stocknow_by_product WHERE productid=R.Product AND branch='6' GROUP BY productid),0) AS st6,IFNULL((SELECT IFNULL(SUM(sto),0) FROM stocknow_by_product WHERE productid=R.Product  GROUP BY productid),0) AS stAll FROM(
			SELECT TRIM(Product) AS Product,`Name`,CATEGORYID FROM impproduct WHERE `Status`='ACTIVE' AND Product<>'' AND Product NOT IN(SELECT TRIM(productid) AS Product FROM stocknow_by_product WHERE branch='75' )
			AND CATEGORYID NOT IN(31,1,111,108,11,36,51,61,66,72,89,90,99)) AS R INNER JOIN class c ON c.classid=R.CATEGORYID";

		$result=Yii::app()->jib->createCommand($str)->queryAll();
		$data=array();

	foreach ($result as $key=>$r) {
		$data[]=array(
				'Product'=>$r['Product'],
    			'Name'=>$r['Name'],
				'CATEGORYID'=>$r['CATEGORYID'],
				'classname'=>$r['classname'],
				'st6'=>$r['st6'],
				'stAll'=>$r['stAll'],
			);
	}
	echo json_encode($data);	
	}
	public function actionStockcommartapi($txtsearch=null)
	{
			header('Content-Type: text/html; charset=utf-8');
			$conn=new mssql();
			$conn->mssqlconnect("172.18.0.51", "foxuser", "foxpro");
			$conn->mssqldb("Doctor");
			$query="SET ANSI_WARNINGS ON;";
			$conn->msexecute($query);

			$txtsearch = urldecode($txtsearch);
			$str = "SELECT * FROM fox_StockCM WHERE Branch NOT IN(51) ";
			if($txtsearch<>null || $txtsearch<>''){
			$str.= "AND Product ='".$txtsearch."'";
			}
			// $str.=" ORDER BY Branch";
			$result=$conn->fetchAll($str);


			$str2 = "SELECT '51' AS Branch,'COMMART - NOTEBOOK' AS branchname,a.productid AS Product,a.producname AS Productname,
			stockremain - IFNULL((SELECT SUM(productQty)  FROM commart.orderdoc_web WHERE productCode=a.productid AND productStatus IN(1,2) ),0) AS Qty FROM commart.stock a ";
			if($txtsearch<>null || $txtsearch<>''){
			$str2.= "WHERE productid ='".$txtsearch."'";
			}
			$Branch51=Yii::app()->jib->createCommand($str2)->queryAll();

			$data=array();
			$stockall=array();
			$stock51=array();
			foreach($result as  $r) {
				$product = $r['Product'];
				$Branch = $r['Branch'];
				$sql="SELECT TRIM(IFNULL(`Name`,'หาไม่เจอ')) AS Productname,IFNULL((SELECT price1 FROM jib.listprice WHERE Product='$product'),0) AS Price,TRIM(Info7) AS Info7,CATEGORYID FROM impproduct WHERE Product='$product'";
				$Price=Yii::app()->jib->createCommand($sql)->queryRow();
				$sql2="SELECT branch,TRIM(branchname) AS branchname FROM branch WHERE branch='$Branch'";
				$Branch=Yii::app()->jib->createCommand($sql2)->queryRow();
				$stockall[]=array(
				'Branch'=>$r['Branch'],
				'branchname'=>$Branch['branchname'],
    			'Product'=>$r['Product'],
    			'Productname'=>$Price['Productname'],
    			'CATEGORYID'=>$Price['CATEGORYID'],
    			'Warrant'=>$Price['Info7'],
    			'Price'=>$Price['Price'],
				'Qty'=>$r['Qty'],
			);
			}

			foreach($Branch51 as  $r) {
				$product = $r['Product'];

				$sql2="SELECT IFNULL((SELECT price1 FROM jib.listprice WHERE Product='$product'),0) AS Price,TRIM(Info7) AS Info7,CATEGORYID FROM impproduct WHERE Product='$product'";
				$Price2=Yii::app()->jib->createCommand($sql2)->queryRow();
				
				$stockall[]=array(
				'Branch'=>$r['Branch'],
				'branchname'=>$r['branchname'],
    			'Product'=>$r['Product'],
    			'Productname'=>$r['Productname'],
    			'CATEGORYID'=>$Price2['CATEGORYID'],
    			'Warrant'=>$Price2['Info7'],
    			'Price'=>$Price2['Price'],
				'Qty'=>$r['Qty'],
			);
			}

			// $data[]=array(
   //  			'jib'=>$stockall,
   //  			'meeting'=>$stock51
   //  		);


			echo json_encode($stockall);

	}

	public function actionStockcommartapitest($txtsearch=null)
	{
			header('Content-Type: text/html; charset=utf-8');
			$conn=new mssql();
			$conn->mssqlconnect("172.18.0.51", "foxuser", "foxpro");
			$conn->mssqldb("Doctor");
			$query="SET ANSI_WARNINGS ON;";
			$conn->msexecute($query);

			$txtsearch = urldecode($txtsearch);
			$str = "SELECT branch AS Branch,productid AS Product,sto AS Qty FROM stocknow_by_product WHERE branch IN(6,75) ";
			if($txtsearch<>null || $txtsearch<>''){
			$str.= "AND productid LIKE '%".$txtsearch."%'";
			}


			// $str.=" ORDER BY Branch";
			$result=Yii::app()->jib->createCommand($str)->queryAll();
			$data=array();
			foreach($result as  $r) {
				$product = $r['Product'];
				$Branch = $r['Branch'];
				$sql="SELECT TRIM(IFNULL(`Name`,'หาไม่เจอ')) AS Productname,IFNULL((SELECT price1 FROM jib.listprice WHERE Product='$product'),0) AS Price,Info7,CATEGORYID FROM impproduct WHERE Product='$product'";
				$Price=Yii::app()->jib->createCommand($sql)->queryRow();
				$sql2="SELECT branch,TRIM(branchname) AS branchname FROM branch WHERE branch='$Branch'";
				$Branch=Yii::app()->jib->createCommand($sql2)->queryRow();
				$data[]=array(
				'Branch'=>$r['Branch'],
				'branchname'=>$Branch['branchname'],
    			'Product'=>$r['Product'],
    			'Productname'=>$Price['Productname'],
    			'CATEGORYID'=>$Price['CATEGORYID'],
    			'Warrant'=>$Price['Info7'],
    			'Price'=>$Price['Price'],
				'Qty'=>$r['Qty'],
			);
			}
			echo json_encode($data);

	}

	public function actionTestexport()
	{
		$str="SELECT a.* FROM product_onsale a ";
		$result=Yii::app()->jib->createCommand($str)->queryAll();
		foreach($result as  $r) {
				$serialno = $r['ProductSerial'];
				$sql="SELECT cost FROM productsales WHERE serialno='$serialno'";
				$cost=Yii::app()->jib->createCommand($sql)->queryRow();
				$data[]=array(
				'No'=>$r['No'],
    			'serial'=>$serialno,
    			'cost'=>$cost['cost'],
			);
			}
		
		$this->renderPartial("exportnun",array(
			'data'=>$data,
			));		
	}

}
?>