<!DOCTYPE php>
<html>
	<head>
		<?php
            $pageName = "";
            include_once "res/php/header.php";
            include_once "res/php/functions.php";
            include_once "res/php/dbconn.php";

            if (isset($_GET['activation_token']))
            {
                $_SESSION['activation_token'] = $_GET['activation_token'];
            }
		?>
	</head>
	<body>
        <div class="container">
            <h2>
                Almost there!
            </h2>
            <form action="activate_account.php" method="POST">
                <div class="label">E-mail:</div>
                <input type="text" name="email"><br><br>
                <div class="submit_button"><input type="Submit" name="activate_account" value="Activate"></div><br><br>

                <?php
                    if (isset($_POST['activate_account']))
                    {
                        $email = $_POST['email'];
                        $activation_token = $_SESSION['activation_token'];
                        $activation_token_mysql = get_activation_token($email, $conn);
        
                        if ($activation_token == $activation_token_mysql)
                        {
                            activate_account($email, $conn);
                            display_error("Successfully activated ".$email);
                        }
                        elseif (!email_exists($conn, $email))
                        {
                            display_error('That e-mail is not registered');
                        }
                        else
                        {
                            display_error("Something went wrong. Please contact support");
                        }
                    }
                ?>
            </form>
        </div>

		<?php
			include_once "./res/php/footer.php";
		?>
	</body>
</html>
