<html>
	<?php
		$pageName = "Login / Sign Up";
		include_once "res/php/header.php";
	?>
	
	<div class="container">
		<h2>Sign Up</h2>
		<form action="signup.php">
				E-mail:<br>
				<input type="text" name="email"><br><br>
				Password:<br>
				<input type="password" name="password"><br><br>
				Display Name:<br> 
				<input type="text" name="display_name"><br><br>
				<input type="submit" value="Sign Up!">
		</form>
	</div>

	<div class="container">
		<h2>Sign In</h2>
		<form action="signin.php">
				E-mail:<br>
				<input type="text" name="email"><br><br>

				Password:<br>
				<input type="password" name="password"><br><br>
				
				<input type="submit" value="Sign In!">
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
