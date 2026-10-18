<?php

session_start();
require "db.php";

//only agents can access this page
if (!isset($_SESSION["agent_id"]))
    {
        header("Location: agent_login.php");
        exit();
    }
///get ALL open tickets from the database
    $search = $_GET["search"] ?? "";// Get the search term from the query string, default to an empty string if not set
    $search_term = "%" . $search . "%"; // Prepare the search term for a SQL LIKE query by adding wildcards before and after the search term
    $stmt = $conn->prepare("SELECT * FROM tickets WHERE status = 'Open' AND (subject LIKE ? OR description LIKE ?)");
    $stmt->bind_param("ss", $search_term, $search_term); // Bind the search term to the prepared statement as two string parameters for the subject and description fields
    $stmt->execute(); // Execute the prepared statement to retrieve the open tickets that match the search criteria
    $result = $stmt->get_result();  // Get the result set from the executed statement, which contains the open tickets that match the search criteria
// this code block is very interesting, using % wildcards in the SQL LIKE query allows for partial matching of the search term within the subject and description fields of the tickets table. This means that if a user searches for a specific keyword, the query will return all tickets that contain that keyword anywhere in their subject or description, making it easier for agents to find relevant tickets. The use of prepared statements with bound parameters also helps prevent SQL injection attacks, enhancing the security of the application.
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Open Tickets</title>
</head>
<body>
    <h1>Open Tickets</h1>
    <form method="GET" action="agent_tickets.php">
        <input type="text" name="search" placeholder="search ticket subject">
        <button type="submit">Search</button>
    </form>

    <table border="1">
        <tr>
            <th>Ticket ID</th>
            <th>User ID</th>
            <th>Subject</th>
            <th>Description</th>
            <th>Status</th>
            <th>support level</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["ticket_id"]; ?></td>
                <td><?php echo $row["user_id"]; ?></td>
                <td><?php echo $row["subject"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td>
                    <form method="POST" action="update_status.php">
                        <input type="hidden" name="ticket_id" value="<?php echo $row["ticket_id"]; ?>"> <!--  hidden allow web developers to include data in a form that is not visually accessible to users when a form is submitted.-->
                        <select name="status">
                            <option value="Open"
                            <?php if ($row["status"] == "Open") echo "selected"; ?>>
                            Open
                            </option>
                            <Option value="Resolved"
                            <?php if ($row["status"] == "Resolved") echo "selected"; ?>>
                            Resolved
                            </option>
                        </select>
                        <textarea name="resolution_details" placeholder="Enter resolution details"></textarea>
                        <input type="submit" value="Update Status">
                        </form>
                </td>
                <td>
                
                <form method="POST" action="update_level.php">

                    <input type="hidden" name="ticket_id" value="<?php echo $row["ticket_id"]; ?>">
                    <select name="support_level">
                        <option value="1" <?php if ($row["support_level"] == 1) echo "selected"; ?>>Level 1</option>
                        <option value="2" <?php if ($row["support_level"] == 2) echo "selected"; ?>>Level 2</option>
                        <option value="3" <?php if ($row["support_level"] == 3) echo "selected"; ?>>Level 3</option>
                        <option value="4" <?php if ($row["support_level"] == 4) echo "selected"; ?>>Level 4</option> 
                    </select>
                    <input type="submit" value="Update Level">

                </form>
                </td>
            </tr>
        <?php endwhile; ?> <!-- This line ends the while loop that fetches and displays each ticket from the result set. -->
    </table>
    <br>
    <a href="agent_dashboard.php"><button>Back to Dashboard</button></a>
</body>
<!--
C00224126
Daniel O'Neill
agent_tickets.php-->