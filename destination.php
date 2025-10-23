<?php
include 'config.php';
// initial query — load all posts
$sql = "SELECT id, title, author, DATE_FORMAT(date, '%M %e, %Y') AS formatted_date, image, excerpt, rating, category
        FROM posts
        ORDER BY date DESC";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Journal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="destination.css">
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
  <section class="secondhead">
    <div> 
        <h1><i class="fas fa-compass"></i> Travel Journal</h1>
        <p class="subtitle">Stories, tips, and inspiration from around the world</p>
    </div>
   
    <div class="search-container">
      <input type="text" id="search-input" class="search-input" placeholder=" Search stories...">
    </div>
  </section>

  
  <div class="container">
      <div class="main-content">
        <!-- POSTS SECTION (wrapped in #post-results) -->
        <div class="posts-section" id="post-results">
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <div class="post">
                <div class="post-meta">
                  <span class="author"><?= $row['author'] ?></span>
                  <span class="date"><?= $row['formatted_date'] ?></span>
                </div>

                <?php if (!empty($row['image'])): ?>
                  <div class="post-image">
                    <img src="<?= $row['image'] ?>" alt="<?= $row['title'] ?>">
                  </div>
                <?php endif; ?>

                <h2 class="post-title"><?= $row['title'] ?></h2>
                <p class="post-excerpt"><?= $row['excerpt'] ?></p>

                <div class="post-footer">
                  <span class="rating">★ <?= $row['rating'] ?? 4.5 ?></span>
              
                  <a href="post.php?id=<?= $row['id'] ?>" class="read-more">Read More</a>
                  <button class="favourite-btn" data-post-id="<?= $row['id'] ?>" 
                          data-user-id="<?= $_SESSION['user_id'] ?>">
                          <i class="fa-solid fa-bookmark"></i>
                  </button>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p class="no-posts">No posts found.</p>
          <?php endif; ?>
        </div>
    


      <!-- SIDEBAR -->
      <aside class="sidebar">
        <div class="sidebar-section">
          <h3 class="sidebar-title"><i class="fas fa-folder"></i> Categories</h3>
          <ul class="category-list">
            <li data-category="All"><i class="fas fa-globe"></i> All</li>
            <li data-category="Adventure"><i class="fas fa-mountain"></i> Adventure</li>
            <li data-category="Culture"><i class="fas fa-landmark"></i> Culture</li>
            <li data-category="Food & Drink"><i class="fas fa-utensils"></i> Food & Drink</li>
            <li data-category="Photography"><i class="fas fa-camera"></i> Photography</li>
          </ul>
        </div>

        <div class="sidebar-section">
          <h3 class="sidebar-title"><i class="fas fa-clock"></i> Recent Posts</h3>
          <ul class="recent-posts">
            <li>Exploring the Hidden Temples of Kyoto</li>
            <li class="date">October 1, 2025</li>
            <li>Island Paradise: A Week in Maldives</li>
            <li class="date">September 28, 2025</li>
            <li>European Charm: Wandering Through Prague</li>
            <li class="date">September 28, 2025</li>
          </ul>
        </div>

        <div class="sidebar-section">
          <h3 class="sidebar-title"><i class="fas fa-tags"></i> Popular Tags</h3>
          <div class="tags">
            <span class="tag">Travel</span>
            <span class="tag">Adventure</span>
            <span class="tag">Culture</span>
            <span class="tag">Nature</span>
            <span class="tag">Photography</span>
            <span class="tag">Food</span>
          </div>
        </div>
      </aside>

    </div> <!-- .main-content -->
  </div> <!-- .container -->

  <!-- ========== JavaScript: category filter + search ========= -->
  <script>
  // helper: fetch and inject results
  function loadPosts(payload) {
    const formBody = Object.keys(payload).map(k => encodeURIComponent(k) + '=' + encodeURIComponent(payload[k])).join('&');
    fetch('filter.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: formBody
    })
    .then(res => res.text())
    .then(html => {
      document.getElementById('post-results').innerHTML = html;
    })
    .catch(err => console.error('Fetch error:', err));
  }

  //Js to get element from category list and send to function loadpost to filter using ajax and then post using innerHtml
  // category click listeners
  document.querySelectorAll('.category-list li').forEach(li => {
    li.addEventListener('click', () => {
      // highlight active
      document.querySelectorAll('.category-list li').forEach(x => x.classList.remove('active'));
      li.classList.add('active');

      const category = li.getAttribute('data-category') || 'All';
      loadPosts({ category });
    });
  });

  // optional: search input (press Enter or type)
  const searchInput = document.getElementById('search-input');
  let searchTimeout = null;
  searchInput.addEventListener('input', () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      const q = searchInput.value.trim();
      // send both search and category if a category is active
      const active = document.querySelector('.category-list li.active');
      const category = active ? active.getAttribute('data-category') : 'All';
      loadPosts({ category, q });
    }, 350); // debounce
  });

  // optional: press Enter performs immediate search
  searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      const q = searchInput.value.trim();
      const active = document.querySelector('.category-list li.active');
      const category = active ? active.getAttribute('data-category') : 'All';
      loadPosts({ category, q });
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
    const favButtons = document.querySelectorAll('.favourite-btn');

      favButtons.forEach(btn => {
          btn.addEventListener('click', () => {
              const postId = btn.dataset.postId;
              const isLiked = btn.classList.contains('liked');

              fetch('like.php', {
                  method: 'POST',
                  headers: {'Content-Type': 'application/json'},
                  body: JSON.stringify({postId: postId, like: !isLiked})
              })
              .then(res => res.json())
              .then(data => {
                  if (data.success) {
                      // Toggle the visual state
                      btn.classList.toggle('liked');
                  } else {
                      alert(data.message);
                  }
              })
              .catch(err => console.error(err));
          });
      });
  });
  </script>
</body>
</html>
