<!--
C00224126
Daniel O'Neill
user_dashboard.php-->
<?php
session_start();
if (!isset($_SESSION["user_id"])) 

    {
    header("Location: login.php");
    exit();
    }
?>
<!DOCTYPE html>
<html>
    
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>User Dashboard</title>
    </head>
    <a href="user_dashboard.php"><button>Home</button></a>
    <h1>User Dashboard</h1>
    <body>
        <div class="dashboard-links">
        <a href="open_ticket.php">Open Ticket</a>
        <a href="my_tickets.php">My Tickets</a>
        <a href="logout.php">Logout</a>
        </div>
    </body>
</html>