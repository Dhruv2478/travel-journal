<?php
include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Journal</title>
  <link rel="stylesheet" href="journal.css">
  
</head>

<body>
<header>
    <nav class="navbar">
      <div class="logo">Travel Journal</div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Journal</a></li>
        <li><a href="destination.php">Destinations</a></li>
        <li><a href="contact.php">About</a></li>
      </ul>
      

    </nav>
  </header>

<section class = "journal_content">
    <div class = "journal_cards" >
        <div class="card1">
            <h3>Your journal</h3>
            <p>Share your latest adventure</p>
            <a href="entry_form.php" class="btn">New Entry</a>
          </div>

        <div class="card2">
            <h3>Your Entries</h3>
            <p>View all your adventures</p>
            <a href="entries.php" class="btn">New Entry</a>
          </div>

        </div>


    </div>




</section>

  






</body>
</html>