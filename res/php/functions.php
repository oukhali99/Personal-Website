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
		echo($error_string);
	}
?>
