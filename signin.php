<?php
	$pageName = "";
	include_once "res/php/header.php";
	include_once "res/php/functions.php";
	include_once "res/php/dbconn.php";
	
	$f_email = get($conn, "email");
	$f_password = get($conn, "password");
	$hashed_password = md5($f_password);

	$stmt = $conn->stmt_init();
	if (!$stmt)
	{
		display_error("Mysql error: failed to initialize statement");
	}

	$succ = $stmt->prepare("SELECT * FROM Customers where email = ?");
	if (!$succ)
	{
		display_error("Could not prepare mysql statement");		
	}
	
	$succ = $stmt->bind_param("s", $f_email);
	if (!$succ)
	{
		display_error("MySql error: failed to bind param");
	}

	$succ = $stmt->execute();
	if (!$succ)
	{
		display_error("Mysql error: failed to execute statement");
	}
	
	$res = $stmt->get_result();
	if (!$res)
	{
		display_error("Mysql error: failed to get statement result");
	}
	
	$row_count = $res->num_rows;
	if ($row_count == 0)
	{	
		display_error("This e-mail is not registered");
	}
	elseif (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
	{
		display_error("Already logged in");
	}
	else
	{
		$account_row = $res->fetch_assoc();
		$account_hashed_password = $account_row["hashed_password"];
		
		if ($account_hashed_password == $hashed_password)
		{
			$display_name = $account_row["display_name"];

			// login
			$_SESSION["loggedin"] = true;
			$_SESSION["display_name"] = $display_name;

			display_error("Login successful");
			header("location: index.php");
		}
		else
		{
			display_error("Wrong password");
		}
	}
?>
