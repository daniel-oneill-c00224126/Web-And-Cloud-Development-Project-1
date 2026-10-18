<!--
C00224126
Daniel O'Neill
agent_login.php-->
<?php

session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST["Username"];
        $password = $_POST["Password"];

        $stmt = $conn->prepare("SELECT * FROM agents WHERE Username = ? AND Password = ?"
        );
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute(); // Execute the prepared statement

        $result = $stmt->get_result(); // Get the result set from the executed statement

        if ($result->num_rows ==1)
            {
                $agent = $result->fetch_assoc(); //this line fetches the user data as an associative array, which allows you to access the user's information using column names as keys.
                $_SESSION["agent_id"] = $agent["agent_id"];
                $_SESSION["agent_username"] = $agent["username"];
                header("Location: agent_dashboard.php");
                exit();
            } else
            {
                echo "<script>alert('Invalid username or password. Please try again.');</script>";      
            }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Agent Login</title>
    </head>
        <a href="index.php"><button>Home</button></a>
    <body>
        <h1>Support Login</h1>
        <form method="POST" action="agent_login.php">
            <div class="form-row"><label>Username</label></div>
            <input type="text" name="Username" required>
            <br><br>
            <div class="form-row"><label>Password</label></div>
            <input type="password" name="Password" required>
            <br><br>
            <button type="submit">Login</button>
        </form>
    </body>
</html>
