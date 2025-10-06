<?php
$servername = "localhost";   // usually localhost
$username   = "root";        // default XAMPP/WAMP username
$password   = "";            // default is empty in XAMPP
$database   = "elms_db";     // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
