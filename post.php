<?php
// Include your database connection
include 'config.php';

// Get post ID from URL (e.g. post.php?id=1)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch post details from database
$query = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $post['title'] ?> | Travel Journal</title>
  <link rel="stylesheet" href="post.css">
</head>
<body>
      <!-- 🔹 NAVIGATION BAR -->
  <header>
    <nav class="navbar">
      <div class="logo">Travel Journal</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Journal</a></li>
        <li><a href="destination.php">Destinations</a></li>
        <li><a href="contact.php">About</a></li>
      </ul>
      <div class="user-icon"><i class="fa-solid fa-user"></i></div>

    </nav>
  </header>

  <div class="container">
    <h2>About <?= $post['title'] ?></h2>
    <div class="content-row">
      
      <!-- LEFT SIDE: Post details -->
      <div class="post-details">
        <img src="<?= $post['image'] ?>" alt="<?= $post['title'] ?>">
        <div class="post-info">
          <p><strong>Place Title:</strong> <?= $post['title'] ?></p>
          <p><strong>Place Type:</strong> <?= $post['type'] ?></p>
          <p><strong>Place Region:</strong> <?= $post['region'] ?></p>
          <p><strong>Place Rating:</strong> ★ <?= $post['rating'] ?></p>
          <p><strong>Place Excerpt:</strong> <?= $post['excerpt'] ?></p>
          <p><strong>Place Description:</strong> <?= $post['description'] ?></p>
          <p><em>Posted by <?= $post['author'] ?></em></p>
        </div>
      </div>
>

      <!-- RIGHT SIDE: Feedback Form -->
      <div class="feedback-box">
        <h2>Comment</h2>
        <form action="comment.php" method="POST">
          <label for="name">Name:</label>
          <div class=""><input type="text"  placeholder="Enter Name Here" name="name" required class="feedback-input" >
          </div>
          <br>
          <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
          <label>Which Category This Picture is?</label>
          <select name="category" required>
            <option value="Culture">Culture</option>
            <option value="Adventure">Adventure</option>
            <option value="Food & Drink">Food & Drink</option>
            <option value="Photography">Photography</option>
          </select>

          <label for="rating">Rating:</label><br>
            <select name="rating" required>
              <option value="1">1 - Poor</option>
              <option value="2">2 - Fair</option>
              <option value="3">3 - Good</option>
              <option value="4">4 - Very Good</option>
              <option value="5">5 - Excellent</option>
            </select><br><br>
          <!--
          <label>What do you rate this? 1-5</label>
          <div class="stars">
            /*
            <?php for($i=1; $i<=5; $i++): ?>
              <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>">
              <label for="star<?= $i ?>">★</label>
            <?php endfor; ?>
          
          </div>
            -->
          <label>Give Your Brief Description</label>
          <textarea name="description" placeholder="Enter Here" required></textarea>
          <button type="submit" >Post</button>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
