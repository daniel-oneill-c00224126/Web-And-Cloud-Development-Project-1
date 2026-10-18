<?php

session_start();
if (!isset($_SESSION["agent_id"])) {
    header("Location: agent_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Agent Support Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION["agent_username"]; ?>!</h1>
    <div class="dashboard-links">
        <a href="agent_tickets.php">View Open Tickets</a>
        <a href="logout.php">Logout</a>
    </div>
</body>