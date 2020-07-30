<!DOCTYPE html>
<html>
        <head>
                <?php

                        $pageName = "Contact";
                        include "./res/php/header.php";
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
				Subject:<br>
                                <textarea name="subject" cols="100" rows="1"></textarea><br><br>
                                
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
