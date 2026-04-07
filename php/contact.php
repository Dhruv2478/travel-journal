<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="../css/contact.css">
    </head>
    <body>
        <!-- NAVIGATION BAR -->
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
          
        </section>

        <section class="contact-section">
            <h2>Get In Touch</h2>
            <p>Have a question, suggestion, or just want to say hello? I'd love to hear from you!</p>

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

                <form id="contact-form" class="contact-form" action="#" method="POST" onsubmit="return false;">
                    <div class="form-group">
                        <input type="text" id="userName" name="name" placeholder="Your Name"
                            value="" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>

                    <div class="form-group">
                        <input type="email" id="userEmail" name="email" placeholder="Your Email"
                            value="" required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>

                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject"
                            value="" required>
                        <i class="fas fa-tag input-icon"></i>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" required></textarea>
                        <i class="fas fa-comment input-icon textarea-icon"></i>
                    </div>
                    <button id="submit-btn" type="button" class="submit-btn" onclick="ajaxGET()">
                        <span>Send Message</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                    <div id="message" style="display:none;"></div>
                </form>
            </div>
        </section>

        <script>
            function ajaxGET() {
                var httpRequest = new XMLHttpRequest();
                var nameValue = document.getElementById('userName').value;
                var emailValue = document.getElementById('userEmail').value;
                var messageBox = document.getElementById('message');

                if (!nameValue || !emailValue) {
                    messageBox.style.display = 'flex';
                    messageBox.className = 'error-message';
                    messageBox.innerHTML = '<i class="fas fa-exclamation-circle"></i>Please enter your name and email.';
                    return;
                }

                httpRequest.open('GET', 'get_message.php?name=' + encodeURIComponent(nameValue) + '&userEmail=' + encodeURIComponent(emailValue), true);
                httpRequest.onreadystatechange = function () {
                    if (httpRequest.readyState === 4) {
                        if (httpRequest.status === 200) {
                            var xmlResponse = httpRequest.responseXML;
                            var name = xmlResponse.getElementsByTagName('name')[0].textContent;
                            var email = xmlResponse.getElementsByTagName('email')[0].textContent;
                            var response = 'Hello ' + name + ' Thank you for your message.<br>We will get back to you ASAP via your Email ' + email + '.';
                            messageBox.style.display = 'flex';
                            messageBox.className = 'success-message';
                            messageBox.innerHTML = '<i class="fas fa-check-circle"></i>' + response;

                            setTimeout(function () {
                                messageBox.innerHTML = '';
                                messageBox.style.display = 'none';
                            }, 5000);
                        } else {
                            alert('An error has occurred making the request');
                        }
                    }
                };
                httpRequest.send(null);
            }
        </script>
    </body>
</html>