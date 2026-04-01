<?php
session_start();
include '../database/database_connection.php'; 
?>
<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Journal</title>
  <link rel="stylesheet" href="../css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>
    
  <!--NAVIGATION BAR -->
  <header>
    <nav class="navbar">
      <div class="logo">Travel Journal</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="journal.php">Journal</a></li>
        <li><a href="../php/destination.php">Destinations</a></li>
        <li><a href="contact.php">About</a></li>
      </ul>
    <div class="profile-btn">
        <?php if(isset($_SESSION['username'])): ?>

                <a href="login.php"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
  
        <?php else: ?>
            <a href="login.php"><i class="fa-solid fa-user"></i> </a>
            <a href="login.php"> Login</a>
      
        <?php 
        endif; ?>
    

    </nav>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Travel Journal</h1>
      <p>Share your adventures and discover new places around the world!</p>
      <div class="register"> 
        <a  href="register.html">Join us</a>
      </div>
    </div>
  </section>

  <!-- 🔹 PRIMARY HOME SECTION -->
    <section class="home-section">
        <div class="home-gallery">

            <div class="main-content">
                <h2>Discover places you never knew existed. <br>Time for a refresh</h2>
            </div>

            <div class="side-content">
                <div class="side-images">
                    <div class="placeholder">
                        <img src="../images/travel_journal.jpg" alt="">
                        <h3>Journal</h3>
                        <p>Share your latest adventure</p>
                        <a href="journal.php" class="btn1">New Entry</a>
                        
                    </div>
                    <div class="placeholder">
                        <img src="../images/travel_map.jpg" alt="">
                        <h3>Destinations</h3>
                        <p>Discover new destinations</p>
                        <a href="destination.php" class="btn2">Discover</a>
                    </div>
                </div>

                <div class="text-content">
                    <h3>Turn your adventures into stories worth sharing.</h3>
                </div>
                
            </div>
        </div>
    </section>

  <!-- 🔹 Places Carousel-->
    <section class="featured-section">
        <h2>Featured Destinations</h2>
        <p>Immerse yourself in our latest travel adventures and 
          discover your next destination</p>
        <!-- Custom Carousel -->
        <div class="carousel-container">
            <div class="carousel-wrapper">
                <div class="carousel-slides">
                <!-- Story Card 1 -->
                <div class="carousel-slide card">
                    <img src="../images/kyoto.jpg" alt="Kyoto Temple">
                    <span class="tag">Culture</span>
                    <small>October 1, 2025</small>
                    <h3>Exploring the Hidden Temples of Kyoto</h3>
                    <p>Discover the serene beauty of ancient temples tucked away in the mountains of Japan.</p>
                </div>
                <!-- Story Card 2 -->
                <div class="carousel-slide card">
                    <img src="../images/maldives.jpg" alt="Maldives">
                    <span class="tag">Adventure</span>
                    <small>September 28, 2025</small>
                    <h3>Island Paradise: A Week in Maldives</h3>
                    <p>Crystal clear waters, pristine beaches, and unforgettable sunsets await in this tropical paradise.</p>
                </div>
                <!-- Story Card 3 -->
                <div class="carousel-slide card">
                    <img src="../images/prague.jpg" alt="Prague Street">
                    <span class="tag">Culture</span>
                    <small>September 25, 2025</small>
                    <h3>European Charm: Wandering Through Prague</h3>
                    <p>Gothic architecture, cobblestone streets, and centuries of history in the heart of Europe.</p>
                </div>
                <!-- Story Card 4 -->
                <div class="carousel-slide card">
                    <img src="../images/egypt.jpg" alt="Egypt Pyramids">
                    <span class="tag">History</span>
                    <small>September 10, 2025</small>
                    <h3>Lost Wonders of Ancient Egypt</h3>
                    <p>Mysteries of the pyramids and ancient pharaohs uncovered.</p>
                </div>
                <!-- Story Card 5 -->
                <div class="carousel-slide card">
                    <img src="../images/iceland.jpg" alt="Iceland Northern Lights">
                    <span class="tag">Nature</span>
                    <small>August 25, 2025</small>
                    <h3>Hunting Northern Lights in Iceland</h3>
                    <p>A magical experience beneath dancing skies.</p>
                </div>
                </div>
            </div>
            <!-- Navigation Buttons -->
            <button class="carousel-btn prev-btn" onclick="moveCarousel(-1)">❮</button>
            <button class="carousel-btn next-btn" onclick="moveCarousel(1)">❯</button>
        </div>
    </section>


  <!--NEWSLETTER SECTION -->
    <section class="newsletter">
        <h2>Get Travel Inspiration Weekly!</h2>
        <p>Subscribe to our newsletter and receive the best travel stories, tips, and destination guides directly to your inbox.</p>
        <form id="newsletter-form">
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit" class="btn">Subscribe</button>
        </form>
        <!-- Message box -->
        <div id="newsletter-msg" style="display:none; margin-top:10px;"></div>
    </section>


  <!-- FOOTER -->
    <footer>
        <div class="footer-content">
        <div>
            <h3>Travel Journal</h3>
            <p>Every journey has a story. Discover the world through our travel adventures and let us inspire your next destination.</p>
        </div>

        <div>
            <h4>Quick Links</h4>
            <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="destination.php">Destinations</a></li>
            <li><a href="#">Journal</a></li>
            <li><a href="contact.php">About</a></li>
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
            <p>TravelJournal@gmail.com</p>
        </div>
        </div>
        <p class="copy">&copy; 2025 Travel Journal. All rights reserved.</p>
    </footer>

<script>
// Custom Carousel
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const slidesContainer = document.querySelector('.carousel-slides');
let slidesPerView = 3;

function updateCarousel() {
    const slideWidth = 100 / slidesPerView;
    slidesContainer.style.transform = `translateX(${-currentSlide * slideWidth}%)`;
}

function moveCarousel(direction) {
    const maxSlide = slides.length - slidesPerView;
    currentSlide += direction;
    
    if (currentSlide > maxSlide) {
        currentSlide = 0;
    } else if (currentSlide < 0) {
        currentSlide = maxSlide;
    }
    
    updateCarousel();
}

function handleResize() {
    if (window.innerWidth < 640) {
        slidesPerView = 1;
    } else if (window.innerWidth < 768) {
        slidesPerView = 2;
    } else {
        slidesPerView = 3;
    }
    currentSlide = 0;
    updateCarousel();
}

document.addEventListener('DOMContentLoaded', function() {
    handleResize();
    window.addEventListener('resize', handleResize);
});

// Newsletter Form
document.getElementById("newsletter-form").addEventListener("submit", function(e) {
    e.preventDefault(); 

    const formData = new FormData(this);

    fetch("newsletter.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        const msg = document.getElementById("newsletter-msg");
        msg.style.display = "block";
        msg.style.padding = "10px";
        msg.style.borderRadius = "5px";

        if (data.includes("success")) {
            msg.style.background = "#c8ffe0";
            msg.style.color = "#006622";
        } else {
            msg.style.background = "#ffcece";
            msg.style.color = "#a00000";
        }

        msg.innerHTML = data;
        document.getElementById("newsletter-form").reset();
    });
});
</script>





</body>
</html>
