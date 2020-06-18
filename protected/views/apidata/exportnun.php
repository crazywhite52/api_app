


<?php
// header("Content-type: application/vnd.ms-excel");
// header("Content-Disposition: attachment; filename=ExpleExportBuy_in.xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- 	<script>
alert('ddd');
window.close();
</script> -->
<body>

<?php 

for ($i=0; $i < count($data); $i++) { 
	echo $data[$i]['cost'].'<br>';
}






 ?>



</body>
	</html>
