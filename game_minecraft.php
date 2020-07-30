<!DOCTYPE html>
<html>
	<head>
		<?php
			$pageName = "Minecraft Server";
			include_once "./res/php/header.php";
		?>
	</head>
	<body>
        <div style="font-size: 20px; color: black;">
            Server Address: valiant-soft.ca <br>
            Server Status: 

            <?php
                $host = "valiant-soft.ca";
                $port = 25565;
                $connection = @fsockopen($host, $port);

                if (is_resource($connection))
                {
                    echo "Up";
            
                    fclose($connection);
                }
            
                else
                {
                    echo "Down";
                }
            ?>
        </div>

		<br><img src="./res/images/minecraft1.png" class="minecraftimage"/>
		<br><img src="./res/images/minecraft2.png" class="minecraftimage"/>
		<br><img src="./res/images/minecraft3.png" class="minecraftimage"/>
		<br><img src="./res/images/minecraft4.png" class="minecraftimage"/>

		<?php
			include "./res/php/footer.php";
		?>
	</body>
</html>
