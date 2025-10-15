<?php
session_start();
include 'dbconnection.php'; 

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $stmt = $conn->prepare("SELECT username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    
    if($stmt->num_rows > 0) {
        $stmt->bind_result($username, $hashedPassword);
        $stmt->fetch();

        // Verify password
        if(password_verify($password, $hashedPassword)) {
            $_SESSION['username'] = $username; // store username in session
            header("Location: index.php"); // redirect to homepage
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "No account found with that email!";
    }

    $stmt->close();
    $conn->close();
}
?>
