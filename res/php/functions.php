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

	function send_mail($phpMailer, $recipient_email, $subject, $body)
	{
		$mail = $phpMailer;
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = '465';
		$mail->isHTML();
		$mail->Username = "valiantsoftcontact@gmail.com";
		$mail->Password = "Valiantsoftgmail$";
		$mail->SetFrom('no-reply@valiant-soft.ca');
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($recipient_email);
		$mail->Send();
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

	function email_activated($conn, $email)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "SELECT activated FROM Customers WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);

		$row = mysqli_fetch_assoc($res);
		if (!$row)
		{
			return false;
		}
		return $row['activated'];
	}

	function valid_email($email)
	{
		$regexp = "";
		$match = preg_match($regexp, $email);

		return ($match == 1);
	}

	function get_hashed_password($conn, $email)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "SELECT * FROM Customers WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$num_rows = mysqli_num_rows($res);

		if ($num_rows != 1)
		{
			return NULL;
		}

		$row = mysqli_fetch_assoc($res);
		return $row['hashed_password'];
	}

	function set_hashed_password($conn, $email, $new_unhashed_password)
	{
		$hashed_password = md5($new_unhashed_password);
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "UPDATE Customers SET hashed_password=? WHERE email=?");
		mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $email);
		mysqli_stmt_execute($stmt);
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
			$activation_token = $email.md5(random_bytes(32));
			$password_reset_token = $email.md5(random_bytes(32));

			// Make sure token's are distinct
			while ($activation_token == $password_reset_token)
			{
				$password_reset_token = $email.md5(random_bytes(32));				
			}

			$stmt = $conn->stmt_init();
			if (!$stmt)
			{
				display_error("Mysql error: failed to initialize statement");
			}

			$succ = $stmt->prepare("INSERT INTO Customers (display_name, email, hashed_password, feedback_count, activated, activation_token, password_reset_token) values(?,?,?,0,false,?, ?);");
			if (!$succ)
			{
				display_error("Mysql error: could not prepare mysql statement");
			}

			$succ = $stmt->bind_param("sssss", $display_name, $email, $hashed_password, $activation_token, $password_reset_token);
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
				$html_link = '<a href="https://www.valiant-soft.ca/activate_account.php?activation_token='.$activation_token.'">Link</a>';

				$mail = new PHPMailer();
				send_mail($mail, $email, "Welcome to Valiant Soft Community!", "Activate your account with the following link: ".$html_link);
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
			$account_activated = $account_row["activated"];
			
			if ($account_hashed_password != $hashed_password)
			{
				display_error("Wrong password");				
			}
			elseif (!$account_activated)
			{
				display_error("Account not yet active. Check your e-mail!");
			}
			else
			{
				$display_name = $account_row["display_name"];

				// login
				$_SESSION["loggedin"] = true;
				$_SESSION["display_name"] = $display_name;
				$_SESSION["email"] = $email;

				header("location: index.php");
			}
		}
	}

	function feedback_id_exists($conn, $feedback_id)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "SELECT * FROM Feedback WHERE id=?");
		mysqli_stmt_bind_param($stmt, "s", $feedback_id);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$numrows = mysqli_num_rows($res);

		return ($numrows == 1);
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

		$succ = $stmt->prepare("INSERT INTO Feedback(email, subject, feedback, resolved, id) VALUES(?, ?, ?, false, ?)");
		if (!$succ)
		{
			return false;	
		}
		
		$feedback_id = md5(random_bytes(32));
		while (feedback_id_exists($conn, $feedback_id))
		{
			$feedback_id = md5(random_bytes(32));
		}

		$succ = $stmt->bind_param("ssss", $email, $subject, $feedback, $feedback_id);
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

	function mark_feedback_resolved($conn, $feedback_id)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "UPDATE Feedback SET resolved=true WHERE id=?");
		mysqli_stmt_bind_param($stmt, "s", $feedback_id);
		mysqli_stmt_execute($stmt);
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
		mysqli_stmt_prepare($stmt, "SELECT activation_token FROM Customers WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);

		$row = mysqli_fetch_assoc($res);
		
		if ($row)
		{
			return $row['activation_token'];
		}
		return NULL;
	}

	function get_password_reset_token($conn, $email)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "SELECT activation_token FROM Customers WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);

		$row = mysqli_fetch_assoc($res);
		
		if ($row)
		{
			return $row['password_reset_token'];
		}
		return NULL;
	}

	function activate_account($email, $conn)
	{
		$stmt = mysqli_stmt_init($conn);
		mysqli_stmt_prepare($stmt, "UPDATE Customers SET activated=true WHERE email=?");
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
	}
?>
