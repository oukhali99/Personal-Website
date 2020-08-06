<?php
	$maxFeedback = 2;
    $pageName="";
	include_once "res/php/header.php";
	include_once "res/php/functions.php";
	include_once "res/php/dbconn.php";

    $subject = $_GET["subject"];
    $feedback = $_GET["feedback"];
	$email = $_SESSION["email"];

	// Get number of feedbacks
	$stmt = $conn->stmt_init();
	if (!$stmt)
	{
		display_error("Mysql error: failed to initialize statement");
	}

	$succ = $stmt->prepare("SELECT feedback_count FROM Customers WHERE email=?");
	if (!$succ)
	{
		display_error("Could not prepare mysql statement");		
	}
	
	$succ = $stmt->bind_param("s", $email);
	if (!$succ)
	{
		display_error("MySql error: failed to bind param");
	}

	$succ = $stmt->execute();
	if (!$succ)
	{
		display_error("Mysql error: failed to execute statement");
	}
	
	$res = mysqli_stmt_get_result($stmt);
	if (!$res)
	{
		display_error("Mysql error: failed to get result");
	}

	$mysql_entry = $res->fetch_assoc();
	$feedback_count = $mysql_entry['feedback_count']; // THIS IS THE RESULT WE'RE LOOKING FOR

	if (!$feedback_count || $feedback_count <= $maxFeedback)
	{
		// Post feedback
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
			// Increment feedback
			$stmt = $conn->stmt_init();
			if (!$stmt)
			{
				display_error("Mysql error: failed to initialize statement");
			}

			$succ = $stmt->prepare("UPDATE Customers SET feedback_count=? where email=?");
			if (!$succ)
			{
				display_error("Could not prepare mysql statement");		
			}
			
			$feedback_count++;
			$succ = $stmt->bind_param("ss", $feedback_count, $email);
			if (!$succ)
			{
				display_error("MySql error: failed to bind param");
			}

			$succ = $stmt->execute();
			if (!$succ)
			{
				display_error("Mysql error: failed to execute statement");
			}

			header("location: contact.php");
		}
	}
?>