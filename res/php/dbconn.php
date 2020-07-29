<?php
	define("DB_HOSTNAME", "valiant-soft.ca");
	define("DB_USERNAME", "oussamak");
	define("DB_PASSWORD", "password");
	define("DB_DATABASE", "personal-website");

	$conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	if (!$conn)
	{
		Die("Unable to connect to sql database: ".mysqli_connect_error());
	}
?>
