<?php
// ---------------------------------------------
// Database Configuration
// ---------------------------------------------
$host = "127.0.0.1";       // Database host
$user = "root";            // Database username
$pass = "";                // Database password
<<<<<<< Updated upstream:config.php
$dbname = "travel_journal"; // Database name
=======
$dbname = "travel_journal";
$port = 3307;              // Database port
>>>>>>> Stashed changes:database/database_connection.php

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



