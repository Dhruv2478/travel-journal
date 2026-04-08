<?php
session_start();

/**
 * XML DATA LOADING & VALIDATION
 */
$xmlFile = '../xml/destinations.xml';
$xsdFile = '../xsd/destinations.xsd';
$xslFile = '../xsl/destinations.xsl';

$xml = new DOMDocument();
$xml->load($xmlFile);

// 1. Validate XML against XSD before proceeding
$isValid = @$xml->schemaValidate($xsdFile); 

/**
 * XSLT TRANSFORMATION
 */
if ($isValid) {
    $xsl = new DOMDocument();
    $xsl->load($xslFile);

    $proc = new XSLTProcessor();
    $proc->importStyleSheet($xsl);
    
    // Transform the XML into the HTML posts
    $transformedOutput = $proc->transformToXML($xml);
} else {
    $transformedOutput = "<p class='no-posts'>Error: XML data does not match the schema.</p>";
}
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
                <?= $transformedOutput ?>
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
        // Call the search web service via SOAP client
        const webServiceUrl = '../search-service/client.php?category=' + encodeURIComponent(category) + '&query=' + encodeURIComponent(q);
        fetch(webServiceUrl)
        .then(res => res.text())
        .then(html => {
            document.getElementById('post-results').innerHTML = html;
        })
        .catch(error => {
            console.error('Error calling search service:', error);
            document.getElementById('post-results').innerHTML = '<p class="no-posts">Error loading results. Please try again.</p>';
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