<?php
include 'config.php'; // <-- your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email format.";
        exit;
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "⚠️ Email already subscribed!";
        exit;
    }

    // Insert
    $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo "✅ Subscription success!";
    } else {
        echo "❌ Subscription failed. Try again!";
    }

    $stmt->close();
    $conn->close();
}
?>
