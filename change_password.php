<!DOCTYPE php>
<html>
	<head>
		<?php
			$pageName = "";
            include_once "res/php/header.php";
            include_once "res/php/functions.php";
            include_once "res/php/dbconn.php";
            include_once "./PHPMailer/PHPMailerAutoload.php";

            if (isset($_POST['reset_password']))
            {
                $password_reset_token = $_POST['password_reset_token'];
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $confirm_new_password = $_POST['confirm_new_password'];
                $email = $_POST['email'];

                if (!$password_reset_token || !$old_password || !$new_password || !$confirm_new_password || !$email)
                {
                    display_error("Please fill in all the fields");
                }
                elseif ($new_password != $confirm_new_password)
                {
                    display_error("Passwords do not match");
                }
                elseif (!email_exists($email) || md5($old_password) != get_hashed_password($conn, $email))
                {
                    display_error("Wrong credentials");
                }
                elseif ($password_reset_token != get_password_reset_token($conn, $email))
                {
                    display_error("Wrong reset token");
                }
                else
                {
                    set_hashed_password($conn, $email, $new_password);
                }
            }
		?>
	</head>
    <body>
        <div class="container">
            <h2>Reset Password</h2>
            <form action="change_password.php" method="POST">
                <input type="hidden" name="password_reset_token" value=<?php if (isset($_POST['password_reset_token'])) {echo '"'.$_POST['password_reset_token'].'"';} ?>><br>
                <div class="label">E-Mail</div>
                <input name="email"><br><br>
                <div class="label">Old Password</div>
                <input type="password" name="old_password"><br><br><br>
                <div class="label">New Password</div>
                <input type="password" name="new_password"><br><br>
                <div class="label">Re-Type</div>
                <input type="password" name="confirm_new_password"><br><br>
                <div class="submit_button"><input type="submit" name="reset_password" style="margin-bottom: 1%"></div>
            </form>
        </div>
    </body>
</html>
