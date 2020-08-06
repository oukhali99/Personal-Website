<html>
	<?php
		$pageName = "Login / Sign Up";
		include_once "res/php/header.php";
		include_once "res/php/functions.php";
		include_once "res/php/dbconn.php";
		include_once "./PHPMailer/PHPMailerAutoload.php";
	?>
	
	<div class="container"
		<?php
			if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
			{
				echo 'style="display:none;"';
			}
		?>
	>
		<h2>Sign Up</h2>
		<form action="gate.php" method="POST" id="signup">
				<?php
					if (isset($_POST['signup']))
					{
						$email = $_POST["email"];
						$password = $_POST["password"];
						$display_name = $_POST["display_name"];
					}
				?>


				E-mail:<br>
				<input type="text" name="email" value=<?php if (isset($_POST['signup'])) {echo $email;} ?>><br><br>

				Password:<br>
				<input type="password" name="password" value=<?php if (isset($_POST['signup'])) {echo $password;} ?>><br><br>

				Display Name:<br> 
				<input type="text" name="display_name" value=<?php if (isset($_POST['signup'])) {echo $display_name;} ?>><br><br>

				<input type="submit" name="signup" value="Sign Up!"?><br><br>


				<?php
					if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["display_name"]))
					{
						// Do nothing
					}
					elseif (!$_POST["email"] || !$_POST["password"] || !$_POST["display_name"])
					{
						echo("Fill in the fields");
					}
					else
					{						
						$email = $_POST["email"];
						$password = $_POST["password"];
						$display_name = $_POST["display_name"];

						signup($email, $password, $display_name, $conn);
					}
				?>
		</form>
	</div>

	<div class="container"
		<?php
			if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"])
			{
				echo 'style="display:none;"';
			}
		?>
	>
		<h2>Sign In</h2>
		<form action="gate.php" method="POST">
				<?php
					if (isset($_POST['signin']))
					{
						$email = $_POST["email"];
						$password = $_POST["password"];
					}
				?>


				E-mail:<br>
				<input type="text" name="email" value=<?php if (isset($_POST['signin'])) {echo $email;} ?>><br><br>

				Password:<br>
				<input type="password" name="password" value=<?php if (isset($_POST['signin'])) {echo $password;} ?>><br><br>
				
				<input type="submit" name="signin" value="Sign In!"><br><br>


				<?php
					if (!isset($_POST['signin']))
					{
						// Do nothing
					}
					elseif (!$_POST["email"] || !$_POST["password"])
					{
						echo("Fill in the fields");
					}
					else
					{
						$email = $_POST["email"];
						$password = $_POST["password"];

						signin($email, $password, $conn);
					}
				?>
		</form>
	</div>
</html>
