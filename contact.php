<!DOCTYPE html>
<html>
        <head>
                <?php

                        $pageName = "Contact";
                        include_once "res/php/header.php";
                        include_once "res/php/functions.php";
                        include_once "res/php/dbconn.php";
                ?>
        </head>
        <body>
                
                <div class="container">
                        <h2>Feedback</h2>
                        <form action="feedback.php" style=
                        <?php
                                if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"])
                                {
                                        echo '"display: none;"';
                                }
                        ?>>
				<div>Subject:
                                <textarea name="subject" cols="80" rows="1"></textarea><br><br></div>
                                
				Feedback:<br>
				<textarea name="feedback" cols="100" rows="10"></textarea><br><br>
				<input type="submit" value="Submit">         
                        </form>
                        <p style=
                        <?php
                                if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"])
                                {
                                        echo '"text-align: center;"';
                                }
                                else
                                {
                                        echo '"display: none;"';
                                }
                        ?>>
                                Please login to submit any feedback
                        </p>
                </div>
                
                <?php
                        $stmt = $conn->stmt_init();
                        if (!$stmt)
                        {
                                display_error("Mysql error: failed to initialize statement");
                        }

                        $succ = $stmt->prepare("SELECT * FROM Feedback");
                        if (!$succ)
                        {
                                display_error("Could not prepare mysql statement");		
                        }

                        $succ = $stmt->execute();
                        if (!$succ)
                        {
                                display_error("Mysql error: failed to execute statement");
                        }
                        
                        $res = $stmt->get_result();
                        if (!$res)
                        {
                                display_error("Mysql error: failed to get statement result");
                        }

                        $cur = $res->fetch_assoc();
                        for ($i = 0; $i < 3; $i++)
                        {
                                if (!$cur)
                                {
                                        break;
                                }

                                $email = $cur['email'];
                                $subject = $cur['subject'];
                                $feedback = $cur['feedback'];

                                echo '<div class="container">';
                                echo '<h2>'.$subject.'</h2>';
                                echo '<p>'.$feedback.'</p>';
                                echo '<h3>By: '.$email.'</h3>';
                                echo '</div>';
                                $cur = $res->fetch_assoc();
                        }
                ?>

                <div class="boxes">
                        <div>
                                <h2>
                                        E-mail
                                </h2>
                                <p>
                                        oussama.khalifeh@mail.mcgill.ca
                                </p>
                        </div>
                        <div>
                                <h2>
                                        Github
                                </h2>
                                <p>
                                        oukhali99
                                </p>
                        </div>
                        <div>
                                <h2>
                                        Phone Number
                                </h2>
                                <p>
                                        Currently not available
                                </p>
                        </div>
                </div>
                <?php
                        include "./res/php/footer.php";
                ?>
        </body>
</html>
