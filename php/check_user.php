<?php
include("../database/database_connection.php");

// Tell the browser this response is XML
header('Content-Type: application/xml');

// Get and sanitise inputs
$field = isset($_GET['field']) ? $_GET['field'] : '';
$value = isset($_GET['value']) ? trim($_GET['value']) : '';

$allowed_fields = array('username', 'email');

if (!in_array($field, $allowed_fields) || $value === '') {
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<response><status exists='no'>Invalid request</status></response>";
    exit;
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT id FROM users WHERE $field = ?");
$stmt->bind_param("s", $value);
$stmt->execute();
$stmt->store_result();

echo "<?xml version='1.0' encoding='UTF-8'?>";

if ($stmt->num_rows > 0) {
    // Field value already taken
    echo "<response>";
    echo "<status exists='yes'>" . ucfirst($field) . " already taken</status>";
    echo "</response>";
} else {
    // Field value is available
    echo "<response>";
    echo "<status exists='no'>" . ucfirst($field) . " is available</status>";
    echo "</response>";
}

$stmt->close();
$conn->close();
?>