<?php
session_start();
include '../database/database_connection.php';

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
  <link rel="stylesheet" href="../css/journal.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<header>
  <nav class="navbar">
    <div class="logo">Travel Journal</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="journal.php">Journal</a></li>
      <li><a href="destination.php">Destinations</a></li>
      <li><a href="../php/view_favourites.php">My Favourites</a></li>
      <li><a href="contact.php">About</a></li>
    </ul>
    <div class="profile-btn">
      <a href="login.php"><i class="fa-solid fa-user"></i><?php echo htmlspecialchars($_SESSION['username']); ?></a>
      <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
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
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
              </div>
            <?php endif; ?>

            <div class="entry-details">
              <h3><?php echo htmlspecialchars($row['title']); ?></h3>

              <div class="entry-meta">
                <span><strong><?php echo htmlspecialchars($row['destination']); ?></strong></span>
                <small><?php echo date('M d, Y', strtotime($row['date_posted'])); ?></small>
              </div>

              <p><?php echo nl2br(htmlspecialchars(substr($row['description'], 0, 150))); ?>...</p>
              <small>by <?php echo htmlspecialchars($row['created_by']); ?></small>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="no-entries">
        <p>No journal entries yet. Start sharing your adventures!</p>
        <a href="journal.php">Create Your First Entry</a>
      </div>
    <?php endif; ?>

  </div>
</section>

</body>
</html>
