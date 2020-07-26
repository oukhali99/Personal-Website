<?php
	$pageName = "Sign Up";
	include_once 'res/php/header.php';
	include_once 'res/php/functions.php';	
	include_once 'res/php/dbconn.php';	

	$form_display_name = get($conn, "display_name");
	$form_email = get($conn, "email");
	$form_password = get($conn, "password");
	
	$hashed_password = md5($form_password);
	$value_string = '"'.$form_display_name.'", "'.$form_email.'", "'.$hashed_password.'"';

	echo "Value String: ".$value_string."<br>";
	
	if (email_exists($conn, $form_email))
	{
		echo "User with that email already exists!";
	}
	elseif (!filter_var($form_email, FILTER_VALIDATE_EMAIL))
	{
		echo "Invalid E-mail";
	}
	elseif($form_display_name == "")
	{
		echo "Display name cannot be empty";
	}
	else
	{
		$res = $conn->query("insert into Customers(display_name, email, hashed_password) values(".$value_string.");");

		$stmt = $conn->stmt_init();
		if (!$stmt)
		{
			display_error("Mysql error: failed to initialize statement");
		}

		$succ = $stmt->prepare("INSERT INTO Customers (display_name, email, hashed_password) values(?,?,?);");
		if (!$succ)
		{
			echo("Mysql error: could not prepare mysql statement");
		}

		$succ = $stmt->bind_param("sss");

		if (!$res)
		{
			echo mysqli_error($conn);
		}
		else
		{
			echo "Successfully created account";
		}
	}
?>
<br>

<html>
	Name: <?php echo $form_name; ?><br>
	E-Mail: <?php echo $form_email; ?><br>
	Hashed Password: <?php echo $hashed_password; ?><br>
</html>