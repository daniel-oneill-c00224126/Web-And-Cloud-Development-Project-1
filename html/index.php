<!DOCTYPE html>
<?php
require "db.php";
?><link rel="stylesheet" href="style.css">
<html>
    <head>
        <title>Ticket System</title>
    </head>
    <body>
        <h1><center>Support Ticket System</center></center></h1>

        <?php
            echo "<p><center>Welcome to the Support Ticket System. Please select an option below:</center></p>";
            echo "<ul>";

            ?>
            <button><a href="register.php">Register here</a></button>
            <button><a href="login.php">Login here</a></button>
            <button><a href="agent_login.php">Agent Login</a></button>
            
    </body>
</html>