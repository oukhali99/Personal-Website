<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="./res/css/stylesheet.css">
<title>
	<?php
		session_start();
		
		echo $pageName;
	?>
</title>
<div id="accountinfo">
	<?php
		if ($_SESSION['user'] != NULL && $_SESSION['userID'] != NULL)
		{
			echo "User: ".$_SESSION["user"]." ID: ".$_SESSION["userID"]." ";
     			echo "
			<div>
				<form action='logout.php' method='GET'>
					<input type='submit' value='logout'>
				</form>			
			</div>
			";
		}
	?>
</div>
<div id="navbar">
	<a href="index.php" <?php if ($pageName == "Home"){echo "id='currentPage'";}?>>Home</a>
	<a href="about.php" <?php if ($pageName == "About"){echo "id='currentPage'";}?>>About</a>
	<a href="contact.php" <?php if ($pageName == "Contact"){echo "id='currentPage'";}?>>Contact</a>
	<a href="services.php" <?php if ($pageName == "Services"){echo "id='currentPage'";}?>>Services</a>
	<a href="games.php" <?php if ($pageName == "Games"){echo "id='currentPage'";}?>>Games</a>
	<a href="privacy_policy.php" <?php if ($pageName == "Privacy Policy"){echo "id='currentPage'";}?>>Privacy Policy</a>
</div>
<div id="header">
	<h1>
		<?php
			echo $pageName;
		?>
	</h1>
</div>
