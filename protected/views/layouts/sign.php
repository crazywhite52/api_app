<?php
$baseUrl=Yii::app()->request->baseUrl; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login Page</title>

		<meta name="description" content="Common Buttons &amp; Icons" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/ace_bootstrap/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/fonts.googleapis.com.css" rel="stylesheet">
    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/ace.min.css" rel="stylesheet">

    <link href="<?php echo $baseUrl;?>/ace_bootstrap/css/ace-rtl.min.css" rel="stylesheet">

  </head>
  <body class="login-layout">
 
      <div class="main-container">
  		<?php echo $content;?>
      </div>    
	 
   
    
     <script src="<?php echo $baseUrl;?>/ace_bootstrap/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $baseUrl;?>/ace_bootstrap/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});
			
			
			
			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');
				
				e.preventDefault();
			 });
			 
			});
		</script>
  </body>
</html>
