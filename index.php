<!DOCTYPE php>
<html>
	<head>
		<?php
			$pageName = "Home";
			include "./res/php/header.php";
		?>
	</head>
	<body>
		<img src="./res/images/palmtree.jpg" class="imageright">
		<div class="containerleft">
			<h2>
				Welcome
			</h2>
			<p>
				This website is built using a combination of
				HTML, CSS and PHP. It also uses a MySQL database
				running on a separate Google Cloud Virtual Machine.
				No Wordpress or web frameworks were used at any 
				point during the developpment of this website. Feel
				free to explore and find any bugs you can! The source code
				for this project is public and available on Github. <br><br><br>
				One last thing. With the use of your browser's zoom in function,
				you'll notice that this website is mobile friendly. Thank you for visiting
			</p>
		</div>
		<div class="container">
			<h2>
				Ok but why?
			</h2>
			<div id="fun">Fun</div>
		</div>
		<?php
			include "./res/php/footer.php";
		?>
	</body>
</html>
