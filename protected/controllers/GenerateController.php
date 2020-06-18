<?php

/**
 * 
 */
class GenerateController extends CController
{
    public function actionCodeGenerate()
    {
    	$digitnum = $_POST['digitnum'];
    	$title = $_POST['title'];
    	$lastrows = $_POST['lastrows'];
    	$newcode=MyClass::generateCode("Y","m",$digitnum,$title,$lastrows,"");
    	echo($newcode);

    }

}