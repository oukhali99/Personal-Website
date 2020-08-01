<!DOCTYPE php>
<html>
	<head>
		<?php
			$pageName = "";
            include_once "res/php/header.php";
            include_once "res/php/functions.php";
            include_once "res/php/dbconn.php";

            if (!isset($_GET['activation_token']))
            {
                //header("location: index.php");
                //exit();
            }

            if (isset($_GET['email']))
            {
                $email = $_GET['email'];
                $activation_token = $_GET['activation_token'];
                $_activation_token_mysql = get_activation_token($email, $conn);

                if ($activation_token == $_activation_token_mysql)
                {
                    activate_account($email, $conn);
                    //header("location: index.php");
                }
            }
		?>
	</head>
	<body>
        <div class="container">
            <h2>
                Almost there!
            </h2>
            <form action=<?php echo '"activate_account.php?activation_token='.$activation_token.'"';?>>
                E-mail:
                <input type="text" name="email"><br><br>
                <input type="Submit" value="Activate">
            </form>
        </div>

		<?php
			include_once "./res/php/footer.php";
		?>
	</body>
</html>
