<?php 
	include("topnav.php");
	if(isset($_GET["id"])){
		$bdd->deleteMessage($_GET["id"]);
	}
?>

<script type="text/javascript">
	window.history.back();
</script>