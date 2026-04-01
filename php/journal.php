<?php
session_start();
include 'config.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $destination = htmlspecialchars($_POST['destination']);
    $description = htmlspecialchars($_POST['description']);
    $created_by = htmlspecialchars($username);

    // Handle image upload
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        if (in_array($imageFileType, $allowed_types)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $image_path = $target_file;
        }
    }

    $sql = "INSERT INTO entries (user_id, title, destination, description, image, created_by) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $title, $destination, $description, $image_path, $created_by);
    $stmt->execute();
    $stmt->close();

    header("Location: my_entries.php"); // Redirect after submit
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Travel Journal</title>
  <link rel="stylesheet" href="journal.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>
<header>
  <!-- 🔹 NAVIGATION BAR -->
  <nav class="navbar">
    <div class="logo">Travel Journal</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="journal.php" class="active">Journal</a></li>
      <li><a href="destination.php">Destination</a></li>
      <li><a href="about.php">About</a></li>
    </ul>
    <div class="profile-btn">
      <a href="profile.php"><i class="fa-solid fa-user"></i><?php echo htmlspecialchars($_SESSION['username']); ?></a>
      <a href="logout.php">Logout</a>
    </div>
  </nav>
</header>
<!-- 🔹 Main BAR -->
<section class="journal-content">
  <div class="container">
    <h2>Share Your Adventure</h2>
    <!-- 🔹 Entry Journal Form -->
    <form action="journal.php" method="POST" class="entry-form" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Entry Title" required>
      <input type="text" name="destination" placeholder="Destination" required>
      <textarea name="description" placeholder="Write about your experience..." rows="6" required></textarea>

      <label for="image">Upload an Image:</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit">Add Entry</button>
    </form>
    <div style="text-align: center; margin-top: 30px;">
      <a href="my_entries.php" class="view-entries-btn">View Your Entries</a>
    </div>
  </div>
</section>
</body>
</html>

