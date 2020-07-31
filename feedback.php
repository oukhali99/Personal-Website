<?php
    $pageName="";    
	include_once "res/php/header.php";
	include_once "res/php/functions.php";
	include_once "res/php/dbconn.php";

    $subject = $_GET["subject"];
    $feedback = $_GET["feedback"];
    $email = $_SESSION["email"];

    $stmt = $conn->stmt_init();
	if (!$stmt)
	{
		display_error("Mysql error: failed to initialize statement");
	}

	$succ = $stmt->prepare("INSERT INTO Feedback(email, subject, feedback) VALUES(?, ?, ?)");
	if (!$succ)
	{
		display_error("Could not prepare mysql statement");		
	}
	
	$succ = $stmt->bind_param("sss", $email, $subject, $feedback);
	if (!$succ)
	{
		display_error("MySql error: failed to bind param");
	}

	$succ = $stmt->execute();
	if (!$succ)
	{
		display_error("Mysql error: failed to execute statement");
    }
    else
    {
        header("location: index.php");
    }
?>