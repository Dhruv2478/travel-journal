<?php
include 'config.php';

// receive inputs
$category = $_POST['category'] ?? 'All';
$q = trim($_POST['q'] ?? '');

// build base SQL and params
$params = [];
$types = '';
$where = [];

// if category is not All, filter by category
if ($category !== 'All' && $category !== '') {
    $where[] = "category = ?";
    $params[] = $category;
    $types .= 's';
}

// if search query provided, match title or excerpt
if ($q !== '') {
    $where[] = "(title LIKE ? OR excerpt LIKE ?)";
    $params[] = '%' . $q . '%';
    $params[] = '%' . $q . '%';
    $types .= 'ss';
}

$sql = "SELECT id, title, author, DATE_FORMAT(date, '%M %e, %Y') AS formatted_date, image, excerpt, rating
        FROM posts";

if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

$sql .= " ORDER BY date DESC";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "<p class='no-posts'>Error preparing statement.</p>";
    exit;
}

// bind params dynamically
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<div class='post-meta'>";
        echo "<span class='author'>" . htmlspecialchars($row['author']) . "</span>";
        echo "<span class='date'>" . htmlspecialchars($row['formatted_date']) . "</span>";
        echo "</div>";

        if (!empty($row['image'])) {
            echo "<div class='post-image'><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['title']) . "'></div>";
        }

        echo "<h2 class='post-title'>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p class='post-excerpt'>" . htmlspecialchars($row['excerpt']) . "</p>";
        echo "<div class='post-footer'>";
        echo "<span class='rating'>★ " . htmlspecialchars($row['rating'] ?? 4.5) . "</span>";
        echo "<a href='post.php?id=" . $row['id'] . "' class='read-more'>Read More</a>";
        echo "</div></div>";
    }
} else {
    echo "<p class='no-posts'>No posts found for this category.</p>";
}

$stmt->close();
$conn->close();
?>
