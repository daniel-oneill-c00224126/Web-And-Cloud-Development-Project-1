<?php

session_start();
require "db.php";

//ensure user is logged in

if (!isset($_SESSION["user_id"]))
    {
    
        header("Location: login.php");
        exit();
    }

    //check if user id was submitted
    if (isset($_POST["ticket_id"]))
        {
            $ticket_id = $_POST["ticket_id"];
            $user_id = $_SESSION["user_id"];

            //close the ticket only if it binds to the user id
            $stmt = $conn->prepare(
                "UPDATE tickets SET status = 'Closed' WHERE ticket_id = ? AND user_id =? AND status = 'Resolved'" // where ticket_id = ? means that the ticket_id must match the one submitted by the user, and user_id = ? means that the ticket must belong to the logged-in user, and status = 'Resolved' means that only resolved tickets can be closed
            );
            $stmt->bind_param("ii", $ticket_id, $user_id);
            $stmt->execute();
        }

        //return to the user ticket page
        header("Location: my_tickets.php");
        exit();
        ?>
        <!--
C00224126
Daniel O'Neill
close_ticket.php-->