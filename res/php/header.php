<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="./res/css/stylesheet.css">
<script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js" crossorigin></script>

<title>
	<?php
		if (session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}

		echo $pageName;
		$_SESSION['lastpage'] = $_SERVER['PHP_SELF'];
	?>
</title>

<div style="color: black;">
	<?php
		if (isset($_GET['display_message']))
		{
			echo $_GET['display_message'];
		}
	?>
</div>

<div id="clock"></div>
<script src="clock.js" type="text/jsx"></script>

<div id="accountinfo">
	<?php
		if (isset($_GET['log']))
		{
			session_destroy();
			session_start();
		}
		
		if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
		{
			echo '<p>'.$_SESSION["display_name"].'</p>';
			echo '<a href="account.php">Account</a>';
			echo ' 
			<form style="display:inline-block;" action="'.$_SESSION['lastpage'].'">'.'				
				<input name="log" style="display: none;">
				<input type="submit" value="Logoff">
			</form>';
		}
		elseif ($pageName == "Login / Sign Up")
		{
			// Do nothing
		}
		else
		{
			echo '<a href = "gate.php">Login / Sign Up</a>';
		}
	?>
</div>

<div id="navbar">
	<a href="index.php" <?php if ($pageName == "Home"){echo "id='currentPage'";}?>>Home</a>
	<a href="sourcecode.php" <?php if ($pageName == "Source Code"){echo "id='currentPage'";}?>>Source Code</a>
	<a href="contact.php" <?php if ($pageName == "Contact"){echo "id='currentPage'";}?>>Contact</a>
	<!--<a href="services.php" <?php if ($pageName == "Services"){echo "id='currentPage'";}?>>Services</a>-->
	<a href="games.php" <?php if ($pageName == "Games"){echo "id='currentPage'";}?>>Games</a>
	<!--<a href="privacy_policy.php" <?php if ($pageName == "Privacy Policy"){echo "id='currentPage'";}?>>Privacy Policy</a>-->
</div>

<div id="header">
	<h1>
		<?php
			echo $pageName;
		?>
	</h1>
</div>
