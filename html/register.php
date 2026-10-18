<!DOCTYPE html>
<html>
    <?php
    require "db.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") // $_Server["REQUEST_METHOD"] is a superglobal variable that returns the request method used to access the page (e.g., GET, POST, etc.). In this case, it checks if the request method is POST, which indicates that the form has been submitted.  
        
        {
            $full_name = $_POST["FULL_NAME"];
            $username = $_POST["Username"];
            $password = $_POST["Password"];
            $confirm_password = $_POST["Confirm_Password"];

            if ($password !== $confirm_password)
                {
                    echo "<script>alert('Passwords do not match. Please try again.');</script>";
                }
            else
                {
                    $stmt = $conn->prepare("INSERT INTO users (FULL_NAME, Username, Password) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $full_name, $username, $password); // Bind the parameters to the prepared statement, specifying that all three are strings (s) sss = string, string, string
                    if ($stmt->execute())
                        {
                            echo "<script>alert('Registration successful! You can now log in.');</script>";
                        }
                    else
                        {
                            echo "<script>alert('Error " . $stmt->error . "');</script>";
                        }
                }
        }
        ?>
    <head>
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <a href="index.php"><button>Home</button></a>
    <body>
        <h1><center>Register</center></h1>
        <form method="POST" action="register.php" onsubmit="return checkPasswords()">
            <div class="form-row"><label>Full Name</label></div>
            <input type="text" name="FULL_NAME">
            <br><br>
            <div class="form-row"><label>Username</label></div>
            <input type="text" name="Username">
            <br><br>
            <div class="form-row"><label>Password</label></div>
            <input type="password" name="Password" id="password">
            <br><br>
            <div class="form-row"><label>Confirm Password</label></div>
            <input type="password" name="Confirm_Password" id="confirm_password" placeholder="Confirm Password">
            <br><br>
            <button type="submit">Register</button>
        </form>
        <script>
            function checkPasswords()
            {
                let password = document.getElementById("password").value;
                let confirmPassword = document.getElementById("confirm_password").value;

                if (password !== confirmPassword)
                {
                    alert("Passwords do not match. Please try again.");
                    return false; // Prevent form submission
                }
                return true; // Allow form submission
            }
        </script>
    </body>
    </html>
    <!--
C00224126
Daniel O'Neill
register.php-->