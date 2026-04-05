<?php
session_start();
include '../database/database_connection.php';

// Load all posts initially
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
    <title>Travel Journal - Destinations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/destination.css">
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">Travel Journal</div>
            <ul class="nav-links">
                <li><a href="../php/index.php">Home</a></li>
                <li><a href="../php/journal.php">Journal</a></li>
                <li><a href="../php/destination.php" class="active">Destinations</a></li>
                <li><a href="../php/view_favourites.php">My Favourites</a></li>
                <li><a href="../php/contact.php">About</a></li> 
            </ul>
            <div class="profile-btn">
                <?php if(isset($_SESSION['username'])): ?>
                    <a href="../php/profile.php">
                        <i class="fa-solid fa-user"></i> <?= htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <a href="../php/logout.php" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="../php/login.php">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <section class="secondhead">
        <h1><i class="fas fa-compass"></i> Destinations</h1>
        <p class="subtitle">Stories, tips, and inspiration from around the world</p>
    </section>

    <div class="container">
        <div class="main-content">
            
            <div class="posts-section" id="post-results">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="post">
                            <div class="post-meta">
                                <span class="author"><i class="fa-solid fa-user"></i> <?= htmlspecialchars($row['author']) ?></span>
                                <span class="date"><i class="fa-solid fa-calendar"></i> <?= $row['formatted_date'] ?></span>
                            </div>

                            <?php if (!empty($row['image'])): ?>
                                <div class="post-image">
                                    <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
                                </div>
                            <?php endif; ?>

                            <h2 class="post-title"><?= htmlspecialchars($row['title']) ?></h2>
                            <p class="post-excerpt"><?= htmlspecialchars($row['excerpt']) ?></p>

                            <div class="post-footer">
                                <span class="rating">★ <?= $row['rating'] ?? 4.5 ?></span>
                                
                                <div class="button-group">
                                    <a href="post.php?id=<?= $row['id'] ?>" class="btn-action">Read More</a>
                                    
                                    <a href="../html/add_favourite.html?title=<?= urlencode($row['title']) ?>&location=<?= urlencode($row['category']) ?>" 
                                       class="btn-action">
                                       Add To Favourites
                                    </a>
                                </div>
                            </div>  
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-posts">No destinations found.</p>
                <?php endif; ?>
            </div>

            <aside class="sidebar">
                <div class="sidebar-section">
                    <h3 class="sidebar-title"><i class="fa-solid fa-magnifying-glass"></i> Search</h3>
                    <div class="search-container" style="width: 100%;">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="search-input" class="search-input" placeholder="Search stories...">
                    </div>
                </div>

                <div class="sidebar-section">
                    <h3 class="sidebar-title"><i class="fas fa-folder"></i> Categories</h3>
                    <ul class="category-list">
                        <li data-category="All" class="active"><i class="fas fa-globe"></i> All</li>
                        <li data-category="Adventure"><i class="fas fa-mountain"></i> Adventure</li>
                        <li data-category="Culture"><i class="fas fa-landmark"></i> Culture</li>
                        <li data-category="Food & Drink"><i class="fas fa-utensils"></i> Food & Drink</li>
                        <li data-category="Photography"><i class="fas fa-camera"></i> Photography</li>
                    </ul>
                </div>

                <div class="sidebar-section">
                    <h3 class="sidebar-title"><i class="fas fa-tags"></i> Popular Tags</h3>
                    <div class="tags">
                        <span class="tag">Travel</span>
                        <span class="tag">Nature</span>
                        <span class="tag">Europe</span>
                        <span class="tag">Asia</span>
                    </div>
                </div>
            </aside>

        </div> 
    </div> 

    <script>
    function loadPosts() {
        const q = document.getElementById('search-input').value;
        const activeLi = document.querySelector('.category-list li.active');
        const category = activeLi ? activeLi.getAttribute('data-category') : 'All';

        const params = new URLSearchParams();
        params.append('category', category);
        params.append('q', q);

        fetch('filter.php', {
            method: 'POST',
            body: params
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('post-results').innerHTML = html;
        });
    }

    document.querySelectorAll('.category-list li').forEach(li => {
        li.addEventListener('click', function() {
            document.querySelectorAll('.category-list li').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            loadPosts();
        });
    });

    document.getElementById('search-input').addEventListener('input', loadPosts);
    </script>
</body>
</html>