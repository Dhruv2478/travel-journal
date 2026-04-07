<?php
// Database connection and form processing
include('../database/database_connection.php');

header('Content-Type: application/xml; charset=UTF-8');

function xmlResponse($status, $message)
{
    $safeStatus = htmlspecialchars($status, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $safeMessage = htmlspecialchars($message, ENT_XML1 | ENT_QUOTES, 'UTF-8');

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    echo '<response>';
    echo '<status>' . $safeStatus . '</status>';
    echo '<message>' . $safeMessage . '</message>';
    echo '</response>';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        xmlResponse('error', 'All fields are required!');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        xmlResponse('error', 'Please enter a valid email address!');
    } else {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");

        if (!$stmt) {
            xmlResponse('error', 'Sorry, there was an error sending your message. Please try again later.');
        }

        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            xmlResponse('success', 'Hello ' . $name . ' Thank you for your message. We will get back to you ASAP via your email.');
        } else {
            xmlResponse('error', 'Sorry, there was an error sending your message. Please try again later.');
        }

        $stmt->close();
    }
}

xmlResponse('error', 'Invalid request method.');
?>