<?php
session_start();
// Simulate a logged-in user


include 'config.php'; // your DB connection

// Get JSON data from JS
$data = json_decode(file_get_contents('php://input'), true);

$userId = $_SESSION['user_id'] ?? null;
$postId = $data['postId'] ?? null;
$like = $data['like'] ?? null;

// Validation
if (!$userId || !$postId || !isset($like)) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if ($like) {
    // Add like
    $stmt = $conn->prepare("INSERT IGNORE INTO post_likes (user_id, post_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $postId);
} else {
    // Remove like
    $stmt = $conn->prepare("DELETE FROM post_likes WHERE user_id=? AND post_id=?");
    $stmt->bind_param("ii", $userId, $postId);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>
