<?php
session_start();
include '../database/database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: ../php/index.php"); 
            exit();
        } else {
            $error = "Invalid password.";
            include 'login.php'; 
            exit();
        }
    } else {
        $error = "No account found with that email.";
        include 'login.php';
        exit();
    }
    $stmt->close();
    $conn->close();
}
?>