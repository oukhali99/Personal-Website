<?php
	$pageName = "";
	include_once 'res/php/header.php';
	include_once 'res/php/functions.php';
	include_once 'res/php/dbconn.php';

	$form_name = get($conn, "name");
	$query = "SELECT * FROM ".$form_name;
	$res = mymysqli_query($conn, $query);
	
	if ($res)
	{
		echo "Success, ".mysqli_num_rows($res)." rows";
	}
	else
	{
		echo mysqli_error($conn);
	}
?>

<br>
<?php
	echo "Your query was processed as ".$query;
?>
