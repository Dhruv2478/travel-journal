<?php
include '../database/database_connection.php'; 

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<b><font color='red'>Invalid email format.</font></b>";
        exit;
    }
    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "<b><font color='red'>Already subscribed!</font></b>";
        exit;
    }
    // Insert
    $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        
        echo "<b><font color='green'>Subscribed successfully!</font></b>";
    } else {
        echo "<b><font color='red'>Subscription failed. Try again!</font></b>";
    }

    $stmt->close();
    $check->close();
    $conn->close();
    exit;
}

echo "<b><font color='red'>Invalid request.</font></b>";
?>
