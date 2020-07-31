<?php
	function get($conn, $name)
	{
		$raw = $_GET[$name];
		return $raw;
		//return mysqli_real_escape_string($conn, $raw);
	}

	function email_exists($conn, $email)
	{
		$res = mysqli_query($conn, 'select * from Customers where email="'.$email.'";');
		$count = mysqli_num_rows($res);
		
		return ($count != 0);
	}

	function valid_email($email)
	{
		$regexp = "";
		$match = preg_match($regexp, $email);

		return ($match == 1);
	}

	function display_error($error_string)
	{
		echo('<div style="color: white;">'.$error_string."</div>");
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
			$stmt = $conn->stmt_init();
			if (!$stmt)
			{
				display_error("Mysql error: failed to initialize statement");
			}

			$succ = $stmt->prepare("INSERT INTO Customers (display_name, email, hashed_password) values(?,?,?);");
			if (!$succ)
			{
				display_error("Mysql error: could not prepare mysql statement");
			}

			$succ = $stmt->bind_param("sss", $display_name, $email, $hashed_password);
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
				display_error("Successfully created account");
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

	function feedback($email, $subject, $feedback, $maxFeedback, $conn)
	{
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
	}
?>
