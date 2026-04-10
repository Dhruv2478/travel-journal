<?php
session_start();
include("../database/database_connection.php");

// Tell the browser this response is XML
header('Content-Type: application/xml');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $email    = isset($_POST["email"])    ? trim($_POST["email"])    : '';
    $password = isset($_POST["password"]) ? $_POST["password"]      : '';

    // Basic server-side validation
    if (strlen($username) < 3 || $email === '' || strlen($password) < 6) {
        echo "<?xml version='1.0' encoding='UTF-8'?>";
        echo "<response><error>Invalid input. Please fill all fields correctly.</error></response>";
        exit;
    }

    // Check username is not already taken
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<?xml version='1.0' encoding='UTF-8'?>";
        echo "<response><error>Username or email already exists.</error></response>";
        $check->close();
        $conn->close();
        exit;
    }
    $check->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;

        // Return XML response on successful registration
        echo "<?xml version='1.0' encoding='UTF-8'?>";
        echo "<response>";
        echo "  <new_traveler user_id='" . $user_id . "'>";
        echo "    <username>"       . htmlspecialchars($username) . "</username>";
        echo "    <email>"          . htmlspecialchars($email)    . "</email>";
        echo "    <account_status>Active</account_status>";
        echo "    <journal_stats>";
        echo "      <entries>0</entries>";
        echo "    </journal_stats>";
        echo "  </new_traveler>";
        echo "</response>";

    } else {
        echo "<?xml version='1.0' encoding='UTF-8'?>";
        echo "<response><error>Registration failed. Please try again.</error></response>";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<response><error>Invalid request method.</error></response>";
}
?>