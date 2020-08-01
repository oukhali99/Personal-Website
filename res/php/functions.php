<?php
	function get($conn, $name)
	{
		return $_GET[$name];
	}	

	function display_error($error_string)
	{
		echo('<div style="color: white;">'.$error_string."</div>");
	}

	function display_black($error_string)
	{
		echo('<div style="color: black;">'.$error_string."</div>");
	}

	function email_exists($conn, $email)
	{		
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "SELECT * FROM Customers WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$count = mysqli_num_rows($res);

		return ($count != 0);
	}

	function valid_email($email)
	{
		$regexp = "";
		$match = preg_match($regexp, $email);

		return ($match == 1);
	}

	function signup($email, $password, $display_name, $conn)
	{
		if (email_exists($conn, $email))
		{
			display_error("User with that email already exists!");
		}
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			display_error("Invalid E-mail");
		}
		else
		{
			$hashed_password = md5($password);
			$activation_token = random_bytes(16).$email.random_bytes(16);

			$stmt = $conn->stmt_init();
			if (!$stmt)
			{
				display_error("Mysql error: failed to initialize statement");
			}

			$succ = $stmt->prepare("INSERT INTO Customers (display_name, email, hashed_password, feedback_count, activated, activation_token) values(?,?,?,0,false,?);");
			if (!$succ)
			{
				display_error("Mysql error: could not prepare mysql statement");
			}

			$succ = $stmt->bind_param("ssss", $display_name, $email, $hashed_password, $activation_token);
			if (!$succ)
			{
				display_error("Mysql error: could not bind params");
			}

			$succ = $stmt->execute();
			if (!$succ)
			{
				display_error("Mysql error: failed to execute statement");
			}
			else
			{
				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = "ssl";
				$mail->Host = "smtp.gmail.com";
				$mail->Port = '465';
				$mail->isHTML();
				$mail->Username = "valiantsoftcontact@gmail.com";
				$mail->Password = "Valiantsoftgmail$";
				$mail->SetFrom('no-reply@valiant-soft.ca');
				$mail->Subject = "Welcome to Valiant Soft Community!";
				$mail->Body = "Activate your account with the following link: ".$_SERVER['HTTP_HOST']."/activate_account.php?activation_token=".$activation_token;
				$mail->AddAddress($email);
				$mail->Send();
				display_error("Successfully created account. Check your e-mail for an activation link");
			}
		}
	}

	function signin($email, $password, $conn)
	{
		$hashed_password = md5($password);

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
				$_SESSION["email"] = $email;

				header("location: index.php");
			}
			else
			{
				display_error("Wrong password");
			}
		}
	}

	function get_feedback_count($email, $conn)
	{
		$stmt = $conn->stmt_init();
		if (!$stmt)
		{
			return -1;
		}

		$succ = $stmt->prepare("SELECT feedback_count FROM Customers WHERE email=?");
		if (!$succ)
		{
			return -1;
		}
		
		$succ = $stmt->bind_param("s", $email);
		if (!$succ)
		{
			return -1;
		}

		$succ = $stmt->execute();
		if (!$succ)
		{
			return -1;
		}
		
		$res = mysqli_stmt_get_result($stmt);
		if (!$res)
		{
			return -1;
		}

		$mysql_entry = $res->fetch_assoc();
		return $mysql_entry['feedback_count'];
	}

	function post_feedback($email, $subject, $feedback, $conn)
	{
		$stmt = $conn->stmt_init();
		if (!$stmt)
		{
			return false;
		}

		$succ = $stmt->prepare("INSERT INTO Feedback(email, subject, feedback) VALUES(?, ?, ?)");
		if (!$succ)
		{
			return false;	
		}
		
		$succ = $stmt->bind_param("sss", $email, $subject, $feedback);
		if (!$succ)
		{
			return false;
		}

		$succ = $stmt->execute();
		if (!$succ)
		{
			return false;
		}

		return true;
	}

	function set_feedback_count($email, $feedback_count, $conn)
	{
		$stmt = $conn->stmt_init();
		if (!$stmt)
		{
			display_error("Mysql error: failed to initialize statement");
			return false;
		}

		$succ = $stmt->prepare("UPDATE Customers SET feedback_count=? where email=?");
		if (!$succ)
		{
			display_error("Could not prepare mysql statement");
			return false;	
		}
		
		$succ = $stmt->bind_param("ss", $feedback_count, $email);
		if (!$succ)
		{
			display_error("MySql error: failed to bind param");
			return false;
		}

		$succ = $stmt->execute();
		if (!$succ)
		{
			display_error("Mysql error: failed to execute statement");
			return false;
		}

		return true;
	}

	function feedback($email, $subject, $feedback, $maxFeedback, $conn)
	{
		$feedback_count = get_feedback_count($email, $conn);

		if ($feedback_count == -1)
		{
			display_error("Failed to get feedback count");
		}
		elseif ($feedback_count < $maxFeedback)
		{
			$succ = post_feedback($email, $subject, $feedback, $conn);
			
			if ($succ)
			{
				// Increment feedback
				$feedback_count++;
				$succ = set_feedback_count($email, $feedback_count, $conn);
				if (!$succ)
				{
					display_error("Failed to increment feedback count");
				}
			}
			else
			{
				display_error("Failed to post feedback");
			}
		}
		else
		{
			display_error("Reached max feedback count of ".$maxFeedback);
		}
	}

	function loggedin()
	{
		if (!isset($_SESSION["loggedin"]))
		{
			return false;
		}
		if (!$_SESSION["loggedin"])
		{
			return false;
		}
		
		return true;
	}

	function set_display_name($email, $new_display_name, $conn)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "UPDATE Customers SET display_name=? WHERE email=?");
		mysqli_stmt_bind_param($stmt, "ss", $new_display_name, $email);
		mysqli_stmt_execute($stmt);
		$_SESSION['display_name'] = $new_display_name;
	}

	function get_activation_token($email, $conn)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($conn, "SELECT activation_token FROM Customers WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);

		$row = mysqli_fetch_assoc($res);
		return $row['activation_token'];
	}

	// All this function does is switch a boolean function from false to true
	// This function does no checks or anything
	function activate_account($email, $conn)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "UPDATE Customers SET activated=true WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
	}
?>
