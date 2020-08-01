<!DOCTYPE php>
<html>
	<head>
		<?php
            $pageName = "";
            include_once "res/php/header.php";
            include_once "res/php/functions.php";
            include_once "res/php/dbconn.php";

            if (!isset($_GET['activation_token']) && !isset($_GET['email']))
            {
                header("location: index.php");
                exit();
            }

            if (isset($_GET['activation_token']) && isset($_GET['email']))
            {
                $email = $_GET['email'];
                $activation_token = $_GET['activation_token'];
                $activation_token_mysql = get_activation_token($email, $conn);

                if ($activation_token == $activation_token_mysql)
                {
                    activate_account($email, $conn);
                    header("location: index.php?display_message=Successfully activated account");
                    exit();
                }
                else
                {
                    display_error("Something went wrong. Please contact support");
                }
            }
		?>
	</head>
	<body>
        <div class="container">
            <h2>
                Almost there!
            </h2>
            <form action="activate_account.php">
                <input type="hidden" name="activation_token" value="<?php echo htmlspecialchars($_GET['activation_token']);?>">
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
