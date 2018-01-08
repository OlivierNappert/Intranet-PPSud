<?php 
  	include_once('topnav.php');
  	if(isset($_SESSION['id']))
		session_destroy();
?>

<script src="jquery-3.3.1/jquery.min.js"></script>       
<script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script> 
<script type="text/javascript">
	location.href='index.php';
</script>
