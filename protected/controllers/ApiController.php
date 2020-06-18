<?php
class ApiController extends CController
{
	public function actionCateapi()
	{

		//$cate=$_GET["cate"];
		$productcode1=$_GET["productcode"];
		$productcode=urldecode($productcode1);
		$sql="SELECT
		TRIM(a.Product) AS Product,
		TRIM(a.Name) AS `Name`,
		a.CATEGORYID,
		a.Brand,
		a.Model,
		b.classname,
		c.price1,
		a.Info1,
		a.Info2,
		a.Info3,
		a.Info4,
		a.Info5,
		a.Info6,
		a.Info7,
		a.Info8,
		a.Weight
		FROM
		impproduct AS a
		LEFT JOIN class AS b ON b.classid = a.CATEGORYID
		LEFT JOIN listprice AS c ON c.product = a.Product
		LEFT JOIN stocknow AS d ON d.product = c.product
		WHERE a.CATEGORYID IN(2,15,110) AND a.Product='".$productcode."'
		GROUP BY a.Product";
		$res=Yii::app()->jib->createCommand($sql)->queryAll();
		$data=array();
		foreach ($res as $key=>$r) {
			$data[]=array(
				'product'=>$r['Product'],
				'productname'=>$r['Name'],
				'price1'=>$r['price1'],
				'categoryid'=>$r['CATEGORYID'],
				'brand'=>trim($r['Brand']),
				'model'=>trim($r['Model']),
				'classname'=>trim($r['classname']),
				'Info1'=>trim($r['Info1']),
				'Info2'=>trim($r['Info2']),
				'Info3'=>trim($r['Info3']),
				'Info4'=>trim($r['Info4']),
				'Info5'=>trim($r['Info5']),
				'Info6'=>trim($r['Info6']),
				'Info7'=>trim($r['Info7']),
				'Info8'=>trim($r['Info8']),
				'Weight'=>trim($r['Weight'])
			);
		}
		echo json_encode($data);
	}

	public function actionCateapi2()
	{
		$cate=$_GET["cate"];
		$sql="SELECT
		a.Product,
		TRIM(a.NAME) AS proname,
		a.CATEGORYID,
		a.Brand,
		a.Model,
		b.classname,
		c.price1,
		a.Info1,
		a.Info2,
		a.Info3,
		a.Info4,
		a.Info5,
		a.Info6,
		a.Info7,
		a.Info8
		FROM
		impproduct AS a
		LEFT JOIN class AS b ON b.classid = a.CATEGORYID
		LEFT JOIN listprice AS c ON c.product = a.Product
		LEFT JOIN stocknow AS d ON d.product = c.product
		WHERE
		a.CATEGORYID = '$cate' AND c.price1!=''
		";
		$sql.=" GROUP BY Product";
		$rescount = Yii::app()->jib->createCommand($sql)->queryAll();
		$total = count($rescount);

		$e_page = 300;
		$per_page = 10;
		$chk_page = 0;

		if(empty($_GET["page"])){
			$page = 0;
		}else{
			$chk_page = $_GET["page"];
			$page = $_GET["page"] * $e_page;
		}

		$sql.= " LIMIT $page,$e_page ";
		$total_p = ceil($total / $e_page)-1;
		$before_p = ($chk_page * $e_page) + 1;
//echo $sql;
		$res = Yii::app()->jib->createCommand($sql)->queryAll();

		$data=array();
		$result=array();
		foreach ($res as $key=>$r) {
			$data[]=array(
				'product'=>$r['Product'],
				'productname'=>$r['proname'],
				'price1'=>$r['price1'],
				'categoryid'=>$r['CATEGORYID'],
				'brand'=>$r['Brand'],
				'model'=>$r['Model'],
				'classname'=>$r['classname'],
				'Info1'=>$r['Info1'],
				'Info2'=>$r['Info2'],
				'Info3'=>$r['Info3'],
				'Info4'=>$r['Info4'],
				'Info5'=>$r['Info5'],
				'Info6'=>$r['Info6'],
				'Info7'=>$r['Info7'],
				'Info8'=>$r['Info8']
			);
		}
		$result[]=array(
			'pagetotal'=>$total_p,
			'result'=>$data
		);
		echo json_encode($result);

	}
	public function actionCateapi3() //TEST
	{
		$cate=trim($_GET["cate"]);
		$sql="SELECT
		a.Product,
		TRIM(a. NAME) AS proname,
		a.CATEGORYID,
		a.Brand,
		a.Model,
		b.classname,
		c.price1,
		a.Info1,
		a.Info2,
		a.Info3,
		a.Info4,
		a.Info5,
		a.Info6,
		a.Info7,
		a.Info8
		FROM
		impproduct AS a
		LEFT JOIN class AS b ON b.classid = a.CATEGORYID
		LEFT JOIN listprice AS c ON c.product = a.Product
		LEFT JOIN stocknow AS d ON d.product = c.product
		WHERE
		a.CATEGORYID IN($cate) AND c.price1!='' ";
		$sql.=" GROUP BY Product";
		$rescount = Yii::app()->jib->createCommand($sql)->queryAll();
		$total = count($rescount);
		$e_page = 300;
		$per_page = 10;
		$chk_page = 0;

		if(empty($_GET["page"])){
			$page = 0;
		}else{
			$chk_page = $_GET["page"];
			$page = $_GET["page"] * $e_page;
		}

		$sql.= " LIMIT $page,$e_page ";
		$total_p = round($total / $e_page)-1;
		$before_p = ($chk_page * $e_page) + 1;
//echo $sql.'<br>';
		$res = Yii::app()->jib->createCommand($sql)->queryAll();

		$data=array();
		$result=array();
		foreach ($res as $key=>$r) {

			$data[]=array(
				'no'=>$key+1,
				'product'=>$r['Product'],
				'productname'=>$r['proname'],
				'price1'=>$r['price1'],
				'categoryid'=>$r['CATEGORYID'],
				'brand'=>$r['Brand'],
				'model'=>$r['Model'],
				'classname'=>$r['classname'],
				'Info1'=>$r['Info1'],
				'Info2'=>$r['Info2'],
				'Info3'=>$r['Info3'],
				'Info4'=>$r['Info4'],
				'Info5'=>$r['Info5'],
				'Info6'=>$r['Info6'],
				'Info7'=>$r['Info7'],
				'Info8'=>$r['Info8']
			);
		}
		$result[]=array(
			'pagetotal'=>$total_p,
			'result'=>$data
		);
		echo json_encode($result);

	}
	public function actionCateapi4() //TEST4 2019
	{
		$cate=trim($_GET["cate"]);
		$sql="SELECT
		a.Product,
		TRIM(a. NAME) AS proname,
		a.CATEGORYID,
		a.Brand,
		a.Model,
		b.classname,
		c.price1,
		a.Info1,
		a.Info2,
		a.Info3,
		a.Info4,
		a.Info5,
		a.Info6,
		a.Info7,
		a.Info8
		FROM
		impproduct AS a
		LEFT JOIN class AS b ON b.classid = a.CATEGORYID
		LEFT JOIN listprice AS c ON c.product = a.Product
		LEFT JOIN stocknow AS d ON d.product = c.product
		WHERE
		a.CATEGORYID IN($cate) AND c.price1!='' ";
		$sql.=" GROUP BY Product";
		$rescount = Yii::app()->jib->createCommand($sql)->queryAll();
		$total = count($rescount);
		$e_page = 300;
		$per_page = 10;
		$chk_page = 0;

		if(empty($_GET["page"])){
			$page = 0;
		}else{
			$chk_page = $_GET["page"];
			$page = $_GET["page"] * $e_page;
		}

		$sql.= " LIMIT $page,$e_page ";
		$total_p = round($total / $e_page)-1;
		$before_p = ($chk_page * $e_page) + 1;
		echo $sql.'<br>';
		$res = Yii::app()->jib->createCommand($sql)->queryAll();

		$data=array();
		$result=array();
		foreach ($res as $key=>$r) {

			$data[]=array(
				'no'=>$key+1,
				'product'=>$r['Product'],
				'productname'=>$r['proname'],
				'price1'=>$r['price1'],
				'categoryid'=>$r['CATEGORYID'],
				'brand'=>$r['Brand'],
				'model'=>$r['Model'],
				'classname'=>$r['classname'],
				'Info1'=>$r['Info1'],
				'Info2'=>$r['Info2'],
				'Info3'=>$r['Info3'],
				'Info4'=>$r['Info4'],
				'Info5'=>$r['Info5'],
				'Info6'=>$r['Info6'],
				'Info7'=>$r['Info7'],
				'Info8'=>$r['Info8']
			);
		}
		$result[]=array(
			'pagetotal'=>$total_p,
			'result'=>$data
		);
		echo json_encode($result);

	}


	public function actionJson()
	{
		$sql="SELECT
		CONCAT('(',c.branch,')','JIB',c.branchname) AS branchname,
		CONCAT(TRIM(d.addr1),TRIM(d.addr2)) AS address,
		CONCAT(DATE(CURDATE()+1), ' ', '23:59:00') AS timedelivery,
		b.loaddate,
		d.tel,
		c.branch,
		d.zipcode,
		packing.carload.jobdoc
		FROM
		logistics.logisticsdoc AS a
		LEFT JOIN logistics.logisticsdoc_head AS b ON b.doc_code = a.doc_code
		LEFT JOIN logistics.logisticsdoc_body AS c ON c.loaddoc = b.loaddoc
		LEFT JOIN logistics.branch AS d ON d.branch = c.branch
		LEFT JOIN packing.carload ON packing.carload.packrun = c.packrun
		WHERE
		b.loaddate = '2019-10-15' AND
		a.sup_id = '5'
		GROUP BY c.branch
		LIMIT 10";



		$res=Yii::app()->logistics->createCommand($sql)->queryAll();
		

		$data1=array();
		$data2=array();
		$data3=array();
		$result=array();
		foreach ($res as $key => $r) {
			$data1[]=array(
				'customer_first_name'=>$r['branchname'],
				'customer_address'=>$r['address'],
				'products'=>array('product_code'=>'สินค้าไอที','product_barcode'=>'2019009022')
			);
		}

		$result[]=array(
			'job_mode'=>'2',
			'job_type'=>'1',
			'data'=>$data1
		);


		echo json_encode($result);
	}

}
?>