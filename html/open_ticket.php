<?php 
session_start();
include "db.php";
$message = "";
// Check if the user is logged in

if (!isset($_SESSION["user_id"]))
    {
    header("Location: login.php");
    exit();
    }   
// Check if the form is submitted
if (isset($_POST["subject"], $_POST["description"]))
    {
        $subject = $_POST["subject"];
        $description = $_POST["description"];
        $user_id = $_SESSION["user_id"];

        if(empty($subject) || empty($description))
            {
                $message = "Please fill in all fields.";
            } else
            {
                // Prepare and bind
                $stmt = $conn->prepare("INSERT INTO tickets (user_id, subject, description) VALUES (?, ?, ?)"); // meaning: ? ? ? = user_id, subject, description
                $stmt->bind_param("iss", $user_id, $subject, $description); // the string "iss" passed to bind_param() defines the data types of the variables being bound to the SQL prepared statement placeholders (?).
                // Execute the statement
                if ($stmt->execute())
                    {
                        $message = "Ticket opened successfully.";
                    } else
                    {
                        $message = "Error opening ticket: " . $stmt->error;
                    }
                // Close the statement
                $stmt->close();
            }
    }
?>


<!DOCTYPE html>
<html>
    
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Open Ticket</title>
    </head>
    <body>
        <h1>Open Ticket</h1>
        <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>
        <form method="POST" action="open_ticket.php" onsubmit="return validateTicket()">
            <div class="form-row">
            <label>Subject</label>
            <input type="text" name="subject" id="subject">
            </div>
            <div class="form-row">
            <label>Description</label>
            <textarea name="description" id="description" ></textarea>
            </div>
            <button type="submit">Open Ticket</button>
            <a href="user_dashboard.php" class="back-button">Back to Dashboard</a>
        </form>
        <script>
            function validateTicket() {
                let subject = document.getElementById("subject").value.trim();
                let description = document.getElementById("description").value.trim(); 
                /*
                    Basically this function is used to validate the ticket form before submission. It checks if the subject and description fields are empty. If either field is empty, it displays an alert message asking the user to fill in all fields and prevents the form from being submitted by returning false. If both fields are filled, it allows the form to be submitted by returning true.
                */
                if (subject === "" || description === "") // triple === checks for both value and type equality, ensuring that the variables are not only empty strings but also of the correct type (string). This is a good practice to avoid unexpected behavior in JavaScript.
                {
                    alert("Please fill in all fields.");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>