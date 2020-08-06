<!DOCTYPE html>
<html>
		<head>
				<?php
						$maxFeedback = 2;
						$pageName = "Contact";
						include_once "res/php/header.php";
						include_once "res/php/functions.php";
						include_once "res/php/dbconn.php";
				?>
		</head>
		<body>
				
				<div class="container" style="width: 50%; margin-left: 25%">
					<h2>Feedback</h2>
					<form action="contact.php" method="POST" style=
					<?php
						if (!loggedin())
						{
								echo '"display: none;"';
						}
					?>>

					<div>
						<h3 style="margin: 0; margin-bottom: 1%;">Subject</h3>
						<textarea name="subject" rows="1" style="width: 50%;"></textarea><br><br>
					</div>
								
				<h3 style="margin: 0; margin-bottom: 1%;">Feedback</h3>
				<textarea name="feedback" rows="10" style="width: 50%;"></textarea><br><br>
				<input type="submit" value="Submit" style="font-size: 14px">

								<?php
										if (!isset($_POST["subject"]) || !isset($_POST["feedback"]))
					{
						// Do nothing
					}
					elseif (!$_POST["subject"] || !$_POST["feedback"])
					{
						display_error("Please fill in all the fields");
					}
					else
					{
						$subject = $_POST["subject"];
						$feedback = $_POST["feedback"];

						feedback($_SESSION['email'], $subject, $feedback, $maxFeedback, $conn);
					}
								?>
						</form>
						<p style=
								<?php
										if (!loggedin())
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
				
				<br>
				<h1 id="header">Submitted Feedback</h1>

				<?php
						$stmt = $conn->stmt_init();
						$succ = $stmt->prepare("SELECT * FROM Feedback");
						$succ = $stmt->execute();                        
						$res = $stmt->get_result();

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
								$resolved = $cur['resolved'];

								if ($resolved)
								{
									$cur = $res->fetch_assoc();
									continue;									
								}

								echo '<div class="feedbackContainer">';
								echo '<h3>By: '.$email.'</h3>';
								echo '<h2>Subject: '.$subject.'</h2>';
								echo '<p>'.$feedback.'</p>';
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
