<?php
session_start();
include 'config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $sql = "INSERT INTO entries (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $title, $content);
    $stmt->execute();
    $stmt->close();
}

// Fetch user entries
$sql = "SELECT * FROM entries WHERE user_id = ? ORDER BY date_posted DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Travel Journal</title>
  <link rel="stylesheet" href="journal.css">
</head>
<body>
<header>
  <nav class="navbar">
    <div class="logo">Travel Journal</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="journal.php" class="active">Journal</a></li>
      <li><a href="destinations.php">Destinations</a></li>
      <li><a href="gallery.php">Gallery</a></li>
    </ul>

    <div class="profile-btn">
      <a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
      <a href="logout.php">Logout</a>
    </div>
  </nav>
</header>

<section class="journal-content">
  <div class="container">
    <h2>Share Your Adventure</h2>

    <form action="journal.php" method="POST" class="entry-form">
      <input type="text" name="title" placeholder="Entry Title" required>
      <textarea name="content" placeholder="Write about your experience..." rows="6" required></textarea>
      <button type="submit">Add Entry</button>
    </form>

    <h2>Your Entries</h2>
    <div class="entries-list">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="entry-card">
          <h3><?php echo htmlspecialchars($row['title']); ?></h3>
          <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
          <small>Posted on: <?php echo $row['date_posted']; ?></small>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

</body>
</html>
