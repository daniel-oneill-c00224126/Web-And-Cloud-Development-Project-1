<?php

session_start();
require "db.php";

//make sure agent is actually logged in
if (!isset($_SESSION["agent_id"])) {
    header("Location: agent_login.php");
    exit();
}

//checks if ticket and id were send
if (isset($_POST["ticket_id"]) && isset($_POST["support_level"])) 
    {
        $ticket_id = $_POST["ticket_id"];
        $support_level = $_POST["support_level"];

        //update the support level in the database
        $stmt = $conn->prepare("UPDATE tickets SET support_level = ? WHERE ticket_id = ?");
        $stmt->bind_param("ii", $support_level, $ticket_id);
        $stmt->execute();       
    }

    //redirect back to the agent tickets page
    header("Location: agent_tickets.php");
    exit(); 
    ?>