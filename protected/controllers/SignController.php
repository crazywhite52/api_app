<?php

class SignController extends CController
{
	public $layout="//layouts/sign";

    public function actionIn()
    {
    	$msg=null;
        
    	if(!empty($_POST)){
    		$user_id=addslashes($_POST["user_id"]);
			$user_password=addslashes($_POST["user_password"]);
			$encode=md5($user_password);
			$str="SELECT * FROM sysuser WHERE `name`='$user_id' AND `password`='$encode'";
			$model=Yii::app()->msystem->createCommand($str)->queryRow();
			if(!empty($model)){
				if(!empty($_POST["chkaccess"])){
					$remember=$_POST["chkaccess"];
				}else{
					$remember=1;
				}
				
				#ID User ที่ใช้ Check สิทธ์การเข้าใช้
				$ckeno=new CHttpCookie('cookie_user_no', $model['id']);
				Yii::app()->session["sess_user_no"]=$model['id'];
				$ckeno->expire = time()+3600*24*$remember; 
				Yii::app()->request->cookies['cookie_user_no'] = $ckeno;
				#ID User (รหัสพนักงาน)
				$ckeid=new CHttpCookie('cookie_user_id', $model['name']);
				Yii::app()->session["sess_user_id"]=$model['name'];
				$ckeid->expire = time()+3600*24*$remember; 
				Yii::app()->request->cookies['cookie_user_id'] = $ckeid;
				#ชื่อ-สกุล เล่น
				$ckename=new CHttpCookie('cookie_user_prosonal', trim($model['fullname'])." ".trim($model['surname']).",".trim($model['nickname']));
				Yii::app()->session["sess_user_prosonal"]=trim($model['fullname'])." ".trim($model['surname']).",".trim($model['nickname']);
				$ckename->expire = time()+3600*24*$remember; 
				Yii::app()->request->cookies['cookie_user_prosonal'] = $ckename;
				#ชื่อ เล่น
				$ckename2=new CHttpCookie('cookie_user_nickname',"คุณ".trim($model['nickname']));
				Yii::app()->session["cookie_user_nickname"]=trim("คุณ".trim($model['nickname']));
				$ckename2->expire = time()+3600*24*$remember; 
				Yii::app()->request->cookies['cookie_user_nickname'] = $ckename2;
				#สาขา
				$ckebranch=new CHttpCookie('cookie_user_branch', $model['branch']);
				Yii::app()->session["sess_branch"]=$model['branch'];
				$ckebranch->expire = time()+3600*24*$remember;
				Yii::app()->request->cookies['cookie_user_branch'] = $ckebranch;
				#ชื่อสาขา
				$ckebranchname=new CHttpCookie('cookie_user_branchname', $model['branchname']);
				Yii::app()->session["sess_branchname"]=$model['branchname'];
				$ckebranchname->expire = time()+3600*24*$remember;
				Yii::app()->request->cookies['cookie_user_branchname'] = $ckebranchname;
				#ข้อมูลประเภท User
				$ckesystem=new CHttpCookie('cookie_user_access', $model['system']);
				Yii::app()->session["sess_user_access"]=$model['system'];
				$ckesystem->expire = time()+3600*24*$remember; 
				Yii::app()->request->cookies['cookie_user_access'] = $ckesystem;
				
				$this->redirect(array("/site/index")); exit();
			}else{
				$msg="User ID หรือ Password ไม่ถูกต้อง";
			}
    	}


        $this->render('in', array('msg'=>$msg));
    }

    public function actionOut()
    {
    	Yii::app()->request->cookies->clear();
    	$this->redirect(array('in'));
    }


}