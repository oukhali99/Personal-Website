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
                        <form>
                                <legend><h2>Feedback</h2></legend>
				E-mail:<br>
				<input type="text" name="email"><br>
				Password:<br>
				<input type="password" name="password"><br><br>
				<input type="submit" value="Sign In!">                                
                        </form>
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
