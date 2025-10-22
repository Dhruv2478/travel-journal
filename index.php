<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Journal</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
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

  <!-- 🔹 HERO SECTION -->
  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Travel Journal</h1>
      <p>Share your adventures and discover new places around the world!</p>
      <button class="btn">Join Us Now</button>
    </div>
  </section>

  <!-- 🔹 PRIMARY HOME SECTION -->
    <section class="home-section">
        <h2>Your Primary home deserves love too <br>- time for a refresh</h2>
        <div class="home-gallery">
            <div class="main-image">
                <img src="images/banner.jpg" alt="Mauritius view">
            </div>
            <div class="side-content">
                <div class="side-images">
                    <div class="placeholder">
                        <img src="images/hotel.jpg" alt="">
                    </div>
                    <div class="placeholder1">
                        <img src="images/hotel.jpg" alt="">
                    </div>
                </div>
                <div class="text-content">
                    Testing of our websites also! asfala! hugu
                </div>
            </div>
        </div>
    </section>

  <!-- 🔹 FEATURED STORIES -->
  <section class="featured-section">
    <h2>Featured Stories</h2>
    <p>Immerse yourself in our latest travel adventures and discover your next destination</p>

    <div class="carousel-container">
      <button class="arrow left" onclick="scrollLeft()">&#8592;</button>

      <div class="carousel">
        <!-- Story Card 1 -->
        <div class="card">
          <img src="images/hotel.jpg" alt="Kyoto Temple">
          <span class="tag">Culture</span>
          <small>October 1, 2025</small>
          <h3>Exploring the Hidden Temples of Kyoto</h3>
          <p>Discover the serene beauty of ancient temples tucked away in the mountains of Japan.</p>
          <a href="#">Read More →</a>
        </div>

        <!-- Story Card 2 -->
        <div class="card">
          <img src="images/hotel.jpg" alt="Maldives">
          <span class="tag">Adventure</span>
          <small>September 28, 2025</small>
          <h3>Island Paradise: A Week in Maldives</h3>
          <p>Crystal clear waters, pristine beaches, and unforgettable sunsets await in this tropical paradise.</p>
          <a href="#">Read More →</a>
        </div>

        <!-- Story Card 3 -->
        <div class="card">
          <img src="images/hotel.jpg" alt="Prague Street">
          <span class="tag">Culture</span>
          <small>September 25, 2025</small>
          <h3>European Charm: Wandering Through Prague</h3>
          <p>Gothic architecture, cobblestone streets, and centuries of history in the heart of Europe.</p>
          <a href="#">Read More →</a>
        </div>
      </div>

      <button class="arrow right" onclick="scrollRight()">&#8594;</button>
    </div>
  </section>

  <!-- 🔹 NEWSLETTER SECTION -->
  <section class="newsletter">
    <h2>Get Travel Inspiration Weekly!</h2>
    <p>Subscribe to our newsletter and receive the best travel stories, tips, and destination guides directly to your inbox.</p>
    <form>
      <input type="email" placeholder="Enter your email" required>
      <button type="submit" class="btn">Subscribe</button>
    </form>
  </section>

  <!-- 🔹 FOOTER -->
  <footer>
    <div class="footer-content">
      <div>
        <h3>WanderTales</h3>
        <p>Every journey has a story. Discover the world through our travel adventures and let us inspire your next destination.</p>
      </div>

      <div>
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Destinations</a></li>
          <li><a href="#">Journal</a></li>
          <li><a href="#">Gallery</a></li>
        </ul>
      </div>

      <div>
        <h4>Categories</h4>
        <ul>
          <li><a href="#">Adventure</a></li>
          <li><a href="#">Culture</a></li>
          <li><a href="#">Food & Drink</a></li>
          <li><a href="#">Photography</a></li>
        </ul>
      </div>

      <div>
        <h4>Get In Touch</h4>
        <p>Exploring the world, one story at a time</p>
        <p>📧 hello@wandertales.com</p>
      </div>
    </div>
    <p class="copy">&copy; 2025 WanderTales. All rights reserved.</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
