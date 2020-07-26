<?php
	$pageName = "Logoff";
	include_once "res/php/header.php";
	include_once "res/php/functions.php";
	include_once "res/php/dbconn.php";

	session_destroy();
	header("location: index.php");
?>
