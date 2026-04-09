<?php
// ---------------------------------------------
// Database Configuration
// ---------------------------------------------
$host = "localhost";       // Database host
$user = "root";            // Database username
$pass = "";                // Database password
$dbname = "travel_journal"; 
$port = 3307;              // Database port

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>