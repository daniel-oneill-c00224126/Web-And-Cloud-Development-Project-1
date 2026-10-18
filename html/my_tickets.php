<!--
C00224126
Daniel O'Neill
my_tickets.php-->
<?php

session_start();
require "db.php";

if (!isset($_SESSION["user_id"])) 
    {
    header("Location: login.php");
    exit();
}

    $user_id = $_SESSION["user_id"];

    $stmt = $conn->prepare("SELECT * FROM tickets WHERE user_id = ?" 
);


    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>My Tickets</title>
    </head>
    <body>
        <h1>My tickets</h1>
        <table border="1">
            <tr>
                <th>Ticket ID</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Status</th>            
                <th>Action</th>
                <th>Resolution</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["ticket_id"]; ?></td>
                    <td><?php echo $row["subject"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["status"]; ?></td>
                    <td>
                        <?php if($row["status"] == "Resolved"): ?>
                            <form method="POST" action="close_ticket.php">
                                <input type="hidden" name="ticket_id" 
                                value="<?php echo $row["ticket_id"]; ?>">
                                <button type="submit">Close Ticket</button>
                            </form>
                        <?php endif; ?>
                        <!--endif = if the ticket is resolved, show the close ticket button, otherwise don't show it.-->
                    </td>
                    <td>
                        <?php echo htmlspecialchars($row["resolution_details"] ?? ""); ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a href="user_dashboard.php"><button>Back to Dashboard</button></a>
    </body>
</html>