<?php
	session_start();
	session_unset();
	session_destroy();
	session_start();
	header("Refresh:0, url=index.php");
?>
