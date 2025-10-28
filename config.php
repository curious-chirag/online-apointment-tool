<?php
session_start();

$host = '127.0.0.1';  // use 127.0.0.1 instead of localhost
$user = 'root';
$pass = ''; // keep blank unless you've set a MySQL password
$db   = 'appointment_system';
$port = 3307; // change to 3306 if your MySQL uses that port

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
