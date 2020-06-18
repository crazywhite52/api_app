<?php
@ob_start();
@session_start(); 
$baseUrl=Yii::app()->request->baseUrl; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Venom-Z</title>

    <link href="<?php echo $baseUrl;?>/bootstrap3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/metro-bootstrap/dist/css/metro-bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo $baseUrl;?>/css/style.css" rel="stylesheet">
	<!--  
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
      
      <script src="<?php echo $baseUrl;?>/js/jquery-1.11.1.min.js"></script>
  </head>
  <body>
  
  	<?php $this->beginContent("//layouts/navbar");$this->endContent();?>
  	
  	<div class="container">
  		<?php echo $content;?>
  	</div>


    <script src="<?php echo $baseUrl;?>/bootstrap3/dist/js/bootstrap.min.js"></script>
    
    <!-- JqWidget -->
	<?php echo CHtml::cssFile($baseUrl."/js/jqwidgets/jqwidgets/styles/jqx.base.css");?>
	<?php echo CHtml::cssFile($baseUrl."/js/jqwidgets/jqwidgets/styles/jqx.summer.css");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxcore.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxexpander.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxvalidator.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxinput.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxbuttons.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxscrollbar.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxmenu.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxinput.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxtabs.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxcheckbox.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxlistbox.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxdropdownlist.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxdatetimeinput.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxcalendar.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxtree.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxwindow.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.sort.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.edit.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.storage.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.selection.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.filter.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.columnsresize.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.columnsreorder.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.pager.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.grouping.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.aggregates.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxdata.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxdata.export.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxgrid.export.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/jqwidgets/jqxpanel.js");?>
	<?php echo CHtml::scriptFile($baseUrl."/js/jqwidgets/scripts/gettheme.js");?>
	<!-- End Widget -->
	
  </body>
</html>
