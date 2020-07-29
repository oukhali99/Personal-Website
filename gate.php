<html>
	<?php
		$pageName = "Login / Sign Up";
		include_once "res/php/header.php";
	?>
	
	<div class="container">
		<form action="signup.php">
				<legend><h2>Sign Up</h2></legend>
				E-mail:<br>
				<input type="text" name="email"><br>
				Password:<br>
				<input type="password" name="password"><br>
				Display Name:<br> 
				<input type="text" name="display_name"><br><br>
				<input type="submit" value="Sign Up!">
		</form>
	</div>

	<div class="container">
		<form action="signin.php">
				<legend><h2>Sign In</h2></legend>
				E-mail:<br>
				<input type="text" name="email"><br>
				Password:<br>
				<input type="password" name="password"><br><br>
				<input type="submit" value="Sign In!">
		</form>
	</div>

	<div class="container">
		<form action="sqlinject.php">
			<legend><h2>SQL Injection Test</h2></legend>
			SELECT * FROM :<br> 
			<input type="text" name="name"><br><br>
			<input type="submit" value="Inject!">
		</form>
	</div>
</html>
