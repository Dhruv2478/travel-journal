<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Journal</title>
  <link rel="stylesheet" href="traveljournal.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>

<body>
<header class="website-header">
    <nav class="navbar">
    <div class="logo">
        <p>Travel Journal</p>
    </div>

    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="Journal.php">Journal</a></li>
        <li><a href="Destinations.php">Destinations</a></li>
        <li><a href="Gallery.php">Gallery</a></li>
    </ul>

    <div class="profile-btn">
        <?php if(isset($_SESSION['username'])): ?>
            <a href="profile.php"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?></a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        <?php else: ?>
            <a href="login.php"><i class="fa-solid fa-user" ></i></a>
          
        <?php endif; ?>
    </div>
</nav>

</header>

<main>
    <section class="banner">
        <div class="background"></div>
        <div class="banner-text">
            <h1>Welcome to Travel Journal</h1>
            <p>Share your adventures and discover new places around the world!</p>
            
        </div>
    </section>

    <section class="welcome">
        <div class="cards">
            <div class="card">
                <h3>Journal</h3>
                <p>Share your latest adventure</p>
                <a href="journal.php" class="btn">New Entry</a>
            </div>

            <div class="card">
                <h3>Destinations</h3>
                <p>Discover new destinations</p>
                <a href="destinations.php" class="btn">Discover</a>
            </div>

            <div class="card">
                <h3>Gallery</h3>
                <p>View pictures from your travels</p>
                <a href="Gallery.php" class="btn">View</a>
            </div>
        </div>
    </section>

    <section class="must-visit">
        <div class="container">
            <h2>Must Visit Places</h2>
            <div class="places">
                <div class="place-card">
                    <div class="place-content">
                        <h3>Kyoto, Japan</h3>
                        <img src="kyoto.jpg" alt="Kyoto, Japan" class="place-image">
                        <p>Ancient temples, serene gardens, and traditional tea houses.</p>
                        <div class="tags">
                            <span class="tag">Culture</span>
                            <span class="tag">Zen</span>
                            <span class="tag">Food</span>
                        </div>
                        <a href="destinations.php" class="btn">Learn More</a>
                    </div>
                </div>

                <div class="place-card">
                    <div class="place-content">
                        <h3>Rome, Italy</h3>
                        <img src="rome.jpg" alt="Rome, Italy" class="place-image">
                        <p>The Eternal City, known for its art and romantic architecture.</p>
                        <div class="tags">
                            <span class="tag">Romance</span>
                            <span class="tag">Food</span>
                        </div>
                        <a href="destinations.php" class="btn">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="Website-footer">
    <div class="footer-container">
        <div class="footer-section about">
            <h3>About Us</h3>
            <p>Travel Journal is your personal companion to share adventures, discover new destinations, and connect with fellow travelers around the world.</p>
        </div>

        <div class="footer-section contact">
            <h3>Contact Us</h3>
            <p><a href="contact.html">Fill out our contact form</a></p>
        </div>

        <div class="footer-section social">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-pinterest-p"></i></a>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
