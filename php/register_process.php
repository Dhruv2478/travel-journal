<?php
session_start();
include("../database/database_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $passwordInput = $_POST["password"];

    $password = password_hash($passwordInput, PASSWORD_DEFAULT);
    //basically insert new user in db
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
    //return xml after successful registration
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<travel_journal>';
        echo '<new_traveler user_id="' . $user_id . '">';
        echo '<username>' . htmlspecialchars($username) . '</username>';
        echo '<email>' . htmlspecialchars($email) . '</email>';
        echo '<account_status>Active</account_status>';
        echo '<journal_stats>';
        echo '<entries>0</entries>';
        echo '</journal_stats>';   
        echo '</new_traveler>';    
    } else {
        echo "Registration failed.";
    }
    $stmt->close();
    $conn->close();
}
?>