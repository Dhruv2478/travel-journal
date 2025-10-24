<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="contact.css">
    </head>
    <body>
        <!-- 🔹 NAVIGATION BAR -->
    <header>
        <nav class="navbar">
        <div class="logo">Travel Journal</div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="journal.php">Journal</a></li>
            <li><a href="destination.php">Destinations</a></li>
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

        <section class="about-header">
            <h1>About Travel Journal</h1>
            <p>Where stories and adventures come to life</p>
        </section>

        <section class="contact-section">
            <h2>Get In Touch</h2>
            <p>Have a question, suggestion, or just want to say hello? I'd love to hear from you!</p>

            <!-- Display success/error messages -->
            <?php if (!empty($success)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="contact-container">
                <div class="contact-info">
                    <div class="info-box">
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email</h4>
                        <p>TravelJournal@gmail.com</p>
                    </div>
                    <div class="info-box">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Location</h4>
                        <p>Currently exploring the world, one adventure at a time</p>
                    </div>
                    <div class="info-box">
                        <div class="icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4>Phone</h4>
                        <p>+230 Mauritius</p>
                    </div>
                    <div class="info-box">
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Response Time</h4>
                        <p>Usually within 24 hours</p>
                    </div>
                </div>

                <form class="contact-form" action="support.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name"
                            value="<?php echo isset($name) ? $name : ''; ?>" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email"
                            value="<?php echo isset($email) ? $email : ''; ?>" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>

                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject"
                            value="<?php echo isset($subject) ? $subject : ''; ?>" required>
                        <i class="fas fa-tag input-icon"></i>
                    </div>

                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" required><?php echo isset($message) ? $message : ''; ?></textarea>
                        <i class="fas fa-comment input-icon textarea-icon"></i>
                    </div>

                    <button type="submit" class="submit-btn">
                        <span>Send Message</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </section>
    </body>
</html>