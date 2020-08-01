<html>
	<?php
		$pageName = "Login / Sign Up";
		include_once "res/php/header.php";
		include_once "res/php/functions.php";
		include_once "res/php/dbconn.php";
		include_once "./PHPMailer/PHPMailerAutoload.php";

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.office365.com";
		$mail->Port = '587';
		$mail->isHTML();
		$mail->Username = "darkenedligh99@gmail.com";
		$mail->Password = "";
		$mail->SetFrom('no-reply@valiant-soft.ca');
		$mail->Subject = "Hello World";
		$mail->Body = "Test";
		$mail->AddAddress("oukhali@hotmail.com");
		$mail->Send();
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
		<form action="gate.php" id="signup">
				E-mail:<br>
				<input type="text" name="email"><br><br>
				Password:<br>
				<input type="password" name="password"><br><br>
				Display Name:<br> 
				<input type="text" name="display_name"><br><br>
				<input type="submit" value="Sign Up!"><br><br>
				<?php
					if (!isset($_GET["email"]) || !isset($_GET["password"]) || !isset($_GET["display_name"]))
					{
						// Do nothing
					}
					elseif (!$_GET["email"] || !$_GET["password"] || !$_GET["display_name"])
					{
						echo("Fill in the fields");
					}
					else
					{						
						$email = $_GET["email"];
						$password = $_GET["password"];
						$display_name = $_GET["display_name"];

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
		<form action="gate.php">
				E-mail:<br>
				<input type="text" name="email2"><br><br>

				Password:<br>
				<input type="password" name="password2"><br><br>
				
				<input type="submit" value="Sign In!"><br><br>

				<?php
					if (!isset($_GET["email2"]) || !isset($_GET["password2"]))
					{
						// Do nothing
					}
					elseif (!$_GET["email2"] || !$_GET["password2"])
					{
						echo("Fill in the fields");
					}
					else
					{
						$email = $_GET["email2"];
						$password = $_GET["password2"];

						signin($email, $password, $conn);
					}
				?>
		</form>
	</div>

	<div class="container">
		<h2>SQL Injection Test</h2>
		<form action="sqlinject.php">
			SELECT * FROM :<br> 
			<input type="text" name="name"><br><br>
			<input type="submit" value="Inject!">
		</form>
	</div>
</html>
