<html>
	<?php
		$pageName = "Login / Sign Up";
		include_once "res/php/header.php";
	?>
	
	<form action="signup.php" style="clear: right;">
		<fieldset>
			<legend>Sign Up</legend>
			E-mail:<br>
			<input type="text" name="email"><br>
			Password:<br>
			<input type="password" name="password"><br>
			Display Name:<br> 
			<input type="text" name="display_name"><br><br>
			<input type="submit" value="Sign Up!">
		</fieldset>
	</form>

	<form action="signin.php">
		<fieldset>
			<legend>Sign In</legend>
			E-mail:<br>
			<input type="text" name="email"><br>
			Password:<br>
			<input type="password" name="password"><br><br>
			<input type="submit" value="Sign In!">
		</fieldset>
	</form>

	
	<form action="sqlinject.php">
		<fieldset>
			<legend>SQL Injection Test</legend>
			SELECT * FROM :<br> 
			<input type="text" name="name"><br><br>
			<input type="submit" value="Inject!">
		</fieldset>
	</form>

</html>
