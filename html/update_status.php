<?php

session_start();
require "db.php";

if (!isset($_SESSION["agent_id"])) {
    header("Location: agent_login.php");
    exit();
}

if (isset($_POST["ticket_id"]) && isset($_POST["status"])) {
    $ticket_id = $_POST["ticket_id"];
    $status = $_POST["status"];
    $resolution_details = trim($_POST["resolution_details"] ?? "");
    if ($status == "Resolved" && $resolution_details == "")
        {
            die("Please enter resolution details before resolving the ticket");
        }

    if ($status == "Resolved")
        {
            $stmt = $conn->prepare(
                "UPDATE tickets SET status = ?, resolution_details = ? Where ticket_id = ? AND status = 'Open'"
            );

            $stmt->bind_param("ssi", $status, $resolution_details, $ticket_id);
            $stmt->execute();
        }
}
header("Location: agent_tickets.php");
exit();
?>