<?php
session_start();
include 'config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

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
  <title>My Entries - Travel Journal</title>
  <link rel="stylesheet" href="journal.css">
</head>
<body>

<header>
  <nav class="navbar">
    <div class="logo">Travel Journal</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="journal.php">Journal</a></li>
      <li><a href="destination.php">Destination</a></li>
      <li><a href="about.php">About</a></li>
    </ul>

    <div class="profile-btn">
      <a href="profile.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
      <a href="logout.php">Logout</a>
    </div>
  </nav>
</header>

<section class="journal-content">
  <div class="container">
    <h2>My Journal Entries</h2>

    <?php if ($result->num_rows > 0): ?>
      <div class="entries-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="entry-card">
            <?php if (!empty($row['image'])): ?>
              <div class="entry-image">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Journal Image">
              </div>
            <?php endif; ?>

            <div class="entry-details">
              <h3><?php echo htmlspecialchars($row['title']); ?></h3>

              <div class="entry-meta">
                <span><strong>Destination:</strong> <?php echo htmlspecialchars($row['destination']); ?></span>
                <small><?php echo $row['date_posted']; ?></small>
              </div>

              <p><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
              <small>Posted by <?php echo htmlspecialchars($row['created_by']); ?></small>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p>No entries found. Start writing your first adventure!</p>
    <?php endif; ?>

  </div>
</section>

</body>
</html>
