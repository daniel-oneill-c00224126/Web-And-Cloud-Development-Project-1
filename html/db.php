<?php

$host = "db";
$user = "ticketuser";
$password = "ticketpassword";
$database = "ticket_system";

$conn = new mysqli(
    $host,
    $user,
    $password,
    $database
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}