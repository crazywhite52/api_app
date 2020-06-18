<?php

class ApidataTestController extends CController
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
		SELECT *,'2' AS `status`,'แผนกเคลมรับสินค้า' AS stepname,authorid2 AS per_id,authorname2 AS p_name,authordate2 AS c_date ,'23' AS br FROM claimdoc WHERE claimno = '$cl'
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
				$c_date =MyClass::monthThaiFull($date_job);
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
				$type_post=$tp.':'.$r['postcode'];
			}

			$var=null;
 	$status=null;
 	$st_docdetail=$r['st_docdetail'];
	$string = $st_docdetail;
	
  	// if(stristr($string, 'เสนอคืนเงิน') === FALSE) {
    // 	$var = '"เสนอคืนเงิน" not found in string';
	// 	$status=0;
		
  	// }else{
	// 	$var = '"เสนอคืนเงิน" Yes in string';
	// 	$status=1;
	//   }
		 
		  $haystack = "อยู่ในเงื่อนไข,เสนอคืนเงิน,เสนอรุ่นทดแทน,";
		  $needle   = "เสนอคืนเงิน,เสนอรุ่นทดแทน,";
		  $flag = strstr($string, $needle);
		  $flag2 = strstr($string,'เสนอคืนเงิน');
		  
		  if ($flag){
			$status=0;
		  }else if($flag2){
			$status=1;
		  }else{
			$status=0;
		  }
		  


	if($r['status']==3){
		$st3=null;
		if($r['per_id']==''){
			$st3=0;
		}elseif ($r['per_id']!='' and $status==0 or  $status==1) {
			$st3=1;
		}
		$chkb = "SELECT branchname FROM branch WHERE branch='" . $r["docbranch"] . "'";
		$br = Yii::app()->jib->createCommand($chkb)->queryRow();

		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>trim($br['branchname']),
			'suppliername'=>$r['suppliername'],
			'JOB SUP'=>$r['jobsup'],
			'details'=>$r['st_docdetail'],
			'status'=>$st3
		);
	}else if($r['status']==8){
		$txt=null;
		$st8=null;
		if($r['type_pcode']!=''){
			$txt='ส่งสินค้าคืนลูกค้าทางไปรษณีย์';
		}
		if($status==1){
			$st8=0;
		}else{
			if($r['per_id']==''){
				$st8=0;
			}else{
				$st8=1;
			}
		}
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>trim($br['branchname']),
			'suppliername'=>$r['suppliername'],
			'details'=>$txt,
			'type_post'=>$r['type_pcode'],
			'type_name'=>$tp,
			'postcode'=>$type_post,
			'status'=>$st8,
			
				);
	}else if($r['status']==7){
		$st7=null;
		if($status==1){
			$st7=0;
		}else{
			if($r['per_id']==''){
				$st7=0;
			}else{
				$st7=1;
			}
		}
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>trim($br['branchname']),
			'suppliername'=>$r['suppliername'],
			'status'=>$st7
		);
	}else if($r['status']==6){
		$st6=null;
		if($status==1){
			$st6=0;
		}else{
			if($r['per_id']==''){
				$st6=0;
			}else{
				$st6=1;
			}
		}
		$chkb6 = "SELECT branchname FROM branch WHERE branch='" . $r["docbranch"] . "'";
		$br6 = Yii::app()->jib->createCommand($chkb6)->queryRow();
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>trim($br6['branchname']),
			'suppliername'=>$r['suppliername'],
			'status'=>$st6
		);
	}else if($r['status']==5){
		$st5=null;
		if($status==1){
			$st5=0;
		}else{
			if($r['per_id']==''){
				$st5=0;
			}else{
				$st5=1;
			}
		}
		$chkb5 = "SELECT branchname FROM branch WHERE branch='" . $r["docbranch"] . "'";
		$br5 = Yii::app()->jib->createCommand($chkb5)->queryRow();
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>trim($br5['branchname']),
			'suppliername'=>$r['suppliername'],
			'status'=>$st5
		);
	}else if($r['status']==4){
		$st4=null;
		if($status==1){
			$st4=0;
		}else{
			if($r['per_id']==''){
				$st4=0;
			}else{
				$st4=1;
			}
		}
		$chkb4 = "SELECT branchname FROM branch WHERE branch='" . $r["docbranch"] . "'";
		$br4 = Yii::app()->jib->createCommand($chkb4)->queryRow();
		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>trim($br4['branchname']),
			'suppliername'=>$r['suppliername'],
			'status'=>$st4
		);
	}else{
		$st1_2=null;
		if($r['per_id']==''){
			$st1_2=0;
		}else{
			$st1_2=1;
		}

		// $st_claim=$r["st_claimtitle"];
		// if($st_claim==1){
		// 	$chkb = "SELECT TRIM(branchname) AS branchname FROM branch WHERE branch='23'";
		// $br2 = Yii::app()->jib->createCommand($chkb)->queryRow();
		// }else if ($st_claim==0) {
		// $chkb = "SELECT TRIM(branchname) AS branchname FROM branch WHERE branch='23' ";
		// $br2 = Yii::app()->jib->createCommand($chkb)->queryRow();
		// }
		$sqlbr1_2="SELECT TRIM(branchname) AS branchname FROM msystem.sysuser WHERE name='".$r['per_id']."'";
		$br1_2=Yii::app()->msystem->createCommand($sqlbr1_2)->queryRow();

		


		$records[]=array(
			'step'=>$r['status'],
			'stepname'=>$r['stepname'],
			'authorid'=>$r['per_id'],
			'authorname'=>$r['p_name'],
			'authordate'=>$c_date,
			'branch'=>$br1_2['branchname'],
			'suppliername'=>$r['suppliername'],
			'status'=>$st1_2
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

	public function actionApmobile($searchtxt=null,$branch=null)
	{

		header('Content-Type: text/html; charset=utf-8');

		$sql="SELECT a.branch,TRIM(a.productid) AS productid,a.sto,TRIM(b.`Name`) AS `Name`,b.CATEGORYID,TRIM(b.Brand) AS Brand,IFNULL(l.price1,0) AS price1 FROM jib.stocknow_by_product a
		INNER JOIN impproduct b ON a.productid=b.Product
		LEFT JOIN listprice l ON l.product=a.productid WHERE a.branch ='$branch' ";
		if($searchtxt<>null){
			$sql.=" AND (a.productid LIKE '%".$searchtxt."%' OR  b.`Name` LIKE '%".$searchtxt."%')";
		}

	 // echo($sql);
		$dataapi=Yii::app()->jib->createCommand($sql)->queryAll();
		$data=array();
	// $records=array();
	// $records2=array();
		foreach ($dataapi as $key=>$r) {
		// if($r['branch'] == 6){
		// $records2[]=array(
		// 		'productid'=>$r['productid'],
  //   			'sto'=>$r['sto'],
		// 		'nameproduct'=>$r['Name'],
		// 		'CATEGORYID'=>$r['CATEGORYID'],
		// 		'Brand'=>$r['Brand'],
		// 	);
		// }else{
			$data[]=array(
				'branch'=>$r['branch'],
				'productid'=>$r['productid'],
				'sto'=>$r['sto'],
				'nameproduct'=>$r['Name'],
				'CATEGORYID'=>$r['CATEGORYID'],
				'Brand'=>$r['Brand'],
				'Price'=>$r['price1'],
			);
	// }

		}
	// $data[]=array(
 //    			'stock75'=>$records,
 //    			'stock6'=>$records2,
 //    		);


		echo json_encode($data);

	}


	public function actionJibbranchcategory()
	{
		header('Content-Type: text/html; charset=utf-8');

		$sql="SELECT * FROM jib.class ";
		$dataapi=Yii::app()->jib->createCommand($sql)->queryAll();
		$data=array();
		$records=array();
		$records2=array();
		foreach ($dataapi as $key=>$r) {

			$records[]=array(
				'classid'=>TRIM($r['classid']),
				'classname'=>TRIM($r['classname']),

			);

		}
		$sql2="SELECT branch,branchname FROM jib.branch ";
		$dataapi2=Yii::app()->jib->createCommand($sql2)->queryAll();


		foreach ($dataapi2 as $key=>$r) {

			$records2[]=array(
				'branch'=>TRIM($r['branch']),
				'branchname'=>TRIM($r['branchname']),

			);

		}

		$data[]=array(
			'CATEGORY'=>$records,
			'BRANCH'=>$records2,
		);
		echo json_encode($data);

	}


	public function actionApi_sentpassword()
	{
		$str = "SELECT * FROM webdata.api_sentpassword  ORDER BY datemonth DESC LIMIT 1";
		$dataapi=Yii::app()->jib->createCommand($str)->queryAll();
		$data=array();
		foreach ($dataapi as $key=>$r) {

			$data[]=array(
				// 'datemonth'=>TRIM($r['datemonth']),
				'OTP'=>TRIM($r['OTP']),

			);

		}

	// $data[]=array(
 //    			'password'=>$records2,
 //    		);
		echo json_encode($data);
	}




	public function actionApi_confirmpassword()
	{
		$user_id=addslashes($_POST['email']);
		$user_password=addslashes($_POST['password']);
		$encode=md5($user_password);
		$str="SELECT CONCAT('[ ',TRIM(`name`),' ],',TRIM(nickname)) AS nickname FROM msystem.sysuser WHERE `name`='$user_id' AND `password`='$encode'";
		$model=Yii::app()->jib->createCommand($str)->queryRow();
		$status='';
		if(!empty($model)){
			$status = 'false';
			$nickname = $model['nickname'];
			$email = $user_id;
			$apiKey = "";
			$createdAt = '2017-10-17 06:52:18';
			$data=array(

				'error'=>$status,
				'name'=>$nickname,
				'email'=>$email,
				'apiKey'=>'JIB-xxx-MIS',
				'createdAt'=>$createdAt,
			);
		}else{
			$status = 'true';
			$message = 'Login failed. Incorrect credentials';
			$data=array(

				'error'=>$status,
				'message'=>$message,

			);

		}
		echo json_encode($data);

	}


	public function actionStockcommartapi($search=null)
	{
		header('Content-Type: text/html; charset=utf-8');

		$query="SET ANSI_WARNINGS ON;";

		Yii::app()->db_51->createCommand($query)->execute();

		$str = "SELECT * FROM fox_StockCM ORDER BY Branch ";

		$temp = "CREATE TEMPORARY TABLE  temp_stock(Branch VARCHAR(50),Product VARCHAR(250),Productname TEXT,Warrant VARCHAR(50),Price DOUBLE(40,2),Qty INT(11),CATEGORYID INT(11)) ";
		Yii::app()->web->createCommand($temp)->execute();
		$result=Yii::app()->db_51->createCommand($str)->queryAll();
		$data=array();
		foreach($result as  $r) {
			$product = $r['Product'];
			$sql="SELECT TRIM(IFNULL(`Name`,'หาไม่เจอ')) AS Productname,IFNULL((SELECT price1 FROM jib.listprice WHERE Product='$product'),0) AS Price,Info7,CATEGORYID FROM impproduct WHERE Product='$product'";
			$Price=Yii::app()->jib->createCommand($sql)->queryRow();

			$in = "INSERT INTO temp_stock VALUES ('".$r['Branch']."','".$r['Product']."','".str_replace("\\"," ",$Price['Productname'])."','".$Price['Info7']."',".$Price['Price'].",".$r['Qty'].",".$Price['CATEGORYID'].")";
			Yii::app()->web->createCommand($in)->execute();
		}
		$strnew="SELECT a.* FROM temp_stock a ";
		if( $search<>null || $search <> ''){
			$strnew.="WHERE Product LIKE '%".$search."%' OR Productname LIKE '%".$search."%' ";
		}

		$ResultTemp=Yii::app()->web->createCommand($strnew)->queryAll();

		Yii::app()->web->createCommand("DROP TEMPORARY TABLE temp_stock")->execute();

		foreach($ResultTemp as  $r) {
			$data[]=array(
				'Branch'=>$r['Branch'],
				'Product'=>$r['Product'],
				'Productname'=>$r['Productname'],
				'Warrant'=>$r['Warrant'],
				'Price'=>$r['Price'],
				'Qty'=>$r['Qty'],
				'CATEGORYID'=>$r['CATEGORYID'],
			);
		}


		echo json_encode($data);

	}

	public function actionMeetting_stock51($txtsearch=null)
	{
		$str="SELECT productid,producname,IFNULL(modelid,'') AS model,brand,stockremain FROM commart.stock ";

		if($txtsearch<>null){
			$str.="WHERE productid LIKE '%".$txtsearch."%' OR producname LIKE '%".$txtsearch."%' OR brand LIKE '%".$txtsearch."%' ";
		}

		$Result=Yii::app()->commart->createCommand($str)->queryAll();
		$data=array();
		foreach ($Result as $r) {
			$data[]=array(
				'productid'=>$r['productid'],
				'producname'=>$r['producname'],
				'model'=>$r['model'],
				'brand'=>$r['brand'],
				'stockremain'=>$r['stockremain'],

			);
		}
		echo json_encode($data);


	}


	public function actionNews_commart($txtsearch=null)
	{
		$str="SELECT id,blogdate,title,detail,author FROM mobiledb.ul_blog ";
		if($txtsearch<>null){
			$str.=" WHERE id ='$txtsearch' ";
		}


		$str.=" ORDER BY id DESC";


		$Result=Yii::app()->jib->createCommand($str)->queryAll();
		$data=array();
		foreach ($Result as $r) {
			$data[]=array(
				'id'=>$r['id'],
				'blogdate'=>$r['blogdate'],
				'title'=>$r['title'],
				'detail'=>$r['detail'],
				'author'=>$r['author'],

			);
		}
		echo json_encode($data);


	}

	public function actionIsertnews()
	{

		$title = $_POST['title'];
		$detail = $_POST['detail'];
		$str = "SELECT MAX(id) AS oldid FROM mobiledb.ul_blog";
		$Result=Yii::app()->jib->createCommand($str)->queryRow();
		$newid = $Result['oldid']+1;

		$in = "INSERT INTO mobiledb.ul_blog SET id='$newid',blogdate=NOW(),title='$title',detail='$detail',upd=NOW() ";

		if(Yii::app()->jib->createCommand($in)->execute()){
			echo "TRUE";
		}else{
			echo "FALSE";
		}


	}






}
?>