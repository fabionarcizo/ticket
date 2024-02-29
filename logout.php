<?php  
if(isset($_SESSION)){
	session_destroy();	
}
?>
<script type="text/javascript">
	window.location = "index.php";
</script>