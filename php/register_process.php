<?php

include("../database/database_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $passwordInput = $_POST["password"];

    // Validation
    if (empty($username) || empty($email) || empty($passwordInput)) {
        echo "<script>alert('All fields are required!');</script>";
        exit();
    }

    if (strlen($username) < 4) {
        echo "<script>alert('Username must be at least 4 characters long');</script>";
        exit();
    }

    if (strlen($passwordInput) < 6) {
        echo "<script>alert('Password must be at least 6 characters long');</script>";
        exit();
    }

    // Hash password and insert into database
    $password = password_hash($passwordInput, PASSWORD_DEFAULT);

    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='../html/register.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}

?>