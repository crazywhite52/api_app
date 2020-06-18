<?php
@ob_start();
@session_start(); 
$baseUrl=Yii::app()->request->baseUrl; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Jib Admin</title>

		<meta name="description" content="Common Buttons &amp; Icons" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/ace_bootstrap/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/fonts.googleapis.com.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/ace.min.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/ace-skins.min.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/ace-rtl.min.css" rel="stylesheet">
      
    
    <script src="<?php echo $baseUrl;?>/ace_bootstrap/js/ace-extra.min.js"></script>
    




  </head>
  <body class="no-skin">
  
  	<?php $this->beginContent("//layouts/navbar");$this->endContent();?>
  	<?php #$this->beginContent("//layouts/sidebar");$this->endContent();?>
      <div class="main-content">
				
  		<?php echo $content;?>
      </div>    
		<?php #$this->beginContent("//layouts/setting");$this->endContent();?>	
    <?php $this->beginContent("//layouts/footer");$this->endContent();?>
    
     <script src="<?php echo $baseUrl;?>/ace_bootstrap/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $baseUrl;?>/ace_bootstrap/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo $baseUrl;?>/ace_bootstrap/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
       
		<!-- ace scripts -->
        
		<script src="<?php echo $baseUrl;?>/ace_bootstrap/js/ace-elements.min.js"></script>
		<script src="<?php echo $baseUrl;?>/ace_bootstrap/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('#loading-btn').on(ace.click_event, function () {
					var btn = $(this);
					btn.button('loading')
					setTimeout(function () {
						btn.button('reset')
					}, 2000)
				});
			
				$('#id-button-borders').attr('checked' , 'checked').on('click', function(){
					$('#default-buttons .btn').toggleClass('no-border');
				});
			})
		</script>
  </body>
</html>
