<?php
session_start();
require "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST["Username"];
        $password = $_POST["Password"];

        $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND Password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1)
            {
                $user = $result->fetch_assoc();
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];
                header("Location: user_dashboard.php");
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
    </head>
    <a href="index.php"><button>Home</button></a>
<body>
    <h1>Login</h1>
    <form method="POST" action="login.php">
        <div class="form-row"><label>Username</label></div>
        <input type="text" name="Username">
        <br><br>
        <div class="form-row"><label>Password</label></div>
        <input type="password" name="Password">
        <br><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
<!--
C00224126
Daniel O'Neill
login.php-->