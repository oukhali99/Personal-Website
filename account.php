<!DOCTYPE php>
<html>
	<head>
		<?php
			$pageName = "";
            include_once "res/php/header.php";
            include_once "res/php/functions.php";
            include_once "res/php/dbconn.php";
            
            if (!loggedin())
            {
                header("location: index.php");
            }
		?>
	</head>
	<body>
        <div class="container">
            <h2>
                Account Settings
            </h2>
            <form action="account.php">
                <h2>Change display name</h2>
                New display name:<br>
                <input type="text" name="display_name"><br><br>
                <input type="submit"><br><br>

                <?php
                    if (!isset($_GET["display_name"]))
                    {
                        // Do nothing, the button hasn't been clicked
                    }
                    elseif (!$_GET["display_name"])
                    {
                        // Field was left blank
                        display_error("Please fill in the fields");
                    }
                    else
                    {
                        $display_name = $_GET["display_name"];
                        set_display_name($_SESSION['email'], $display_name, $conn);
                        header("location: account.php");
                    }
                ?>
            </form>
            <form action="account.php">
                <h2>Change password</h2>
                E-Mail:<br>
                <input type="text" name="email"><br><br>
                <input type="submit"><br><br>

                <?php
                    if (!isset($_GET["email"]))
                    {
                        // Do nothing, the button hasn't been clicked
                    }
                    elseif (!$_GET["email"])
                    {
                        // Field was left blank
                        display_error("Please fill in the fields");
                    }
                    else
                    {
                        $email = $_GET["email"];
                        mail($email, "Password reset", "Please follow the link below");
                    }
                ?>
            </form>
        </div>

        <div id="header">
			<h1>
				Pending Feedback
			</h1>
        </div>
        <?php
             $stmt = $conn->stmt_init();
             $succ = $stmt->prepare("SELECT * FROM Feedback");
             $succ = $stmt->execute();                        
             $res = $stmt->get_result();
             $cur = $res->fetch_assoc();

             while ($cur != NULL)
             {
                $email = $cur['email'];
                $subject = $cur['subject'];
                $feedback = $cur['feedback'];
                $feedback_id = $cur['id'];
                $resolved = $cur['resolved'];

                if ($email != $_SESSION['email'] || $resolved)
                {
                    $cur = $res->fetch_assoc();
                    continue;
                }                

                echo '<div class="feedbackContainer" style="width: 90%; margin-left: 5%;">';
                echo '<h3>By: '.$email.'</h3>';
				echo '<h2>Subject: '.$subject.'</h2>';				
                echo '<p>'.$feedback.'</p>';
                
                if (isset($_GET['resolved_feedback_id']) && $_GET['resolved_feedback_id'] == $feedback_id)
                {
                    $feedback_count = get_feedback_count($email, $conn);
                    $new_feedback_count = $feedback_count - 1;

                    mark_feedback_resolved($conn, $feedback_id);
                    set_feedback_count($email, $new_feedback_count, $conn);
                    echo '<div style="text-align: right;"><a>Resolved</a></div>';
                }
                else
                {
                    echo '<div style="text-align: right;"><a href="account.php?resolved_feedback_id='.$feedback_id.'">Mark as Resolved</a></div>';
                }

                echo '</div>';
                $cur = $res->fetch_assoc();
             }
        ?>

		<?php
			include_once "./res/php/footer.php";
		?>
	</body>
</html>
