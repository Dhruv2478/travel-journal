<?php
include 'config.php'; // connect to database
// receive inputs from the user (via POST)
$category = $_POST['category'] ?? 'All';
$q = trim($_POST['q'] ?? '');
// arrays for SQL conditions and parameters
$params = [];
$types = '';
$where = [];
// if category is chosen (not "All"), add it to the filter
if ($category !== 'All' && $category !== '') {
    $where[] = "category = ?";
    $params[] = $category;
    $types .= 's';
}
// if search query is given, filter by title or excerpt
if ($q !== '') {
    $where[] = "(title LIKE ? OR excerpt LIKE ?)";
    $params[] = '%' . $q . '%';
    $params[] = '%' . $q . '%';
    $types .= 'ss';
}
// main SQL query to get posts
$sql = "SELECT id, title, author, DATE_FORMAT(date, '%M %e, %Y') AS formatted_date, image, excerpt, rating
        FROM posts";
// add WHERE conditions if any
if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
// sort posts by most recent
$sql .= " ORDER BY date DESC";
// prepare the SQL statement
$stmt = $conn->prepare($sql);
// if something goes wrong with prepare()
if ($stmt === false) {
    echo "<p>Error preparing statement.</p>";
    exit;
}
// bind parameters if needed
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
// run the query
$stmt->execute();
$result = $stmt->get_result();
// check if we found any posts
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<div class='post-meta'>";
        echo "<span class='author'>" . $row['author'] . "</span>";
        echo "<span class='date'>" . $row['formatted_date'] . "</span>";
        echo "</div>";
        // show image if it exists
        if (!empty($row['image'])) {
            echo "<div class='post-image'><img src='" . $row['image'] . "' alt='" . $row['title'] . "'></div>";
        }
        // post content
        echo "<h2 class='post-title'>" . $row['title'] . "</h2>";
        echo "<p class='post-excerpt'>" . $row['excerpt'] . "</p>";
        // footer: rating + read more link
        echo "<div class='post-footer'>";
        echo "<span class='rating'>★ " . ($row['rating'] ?? 4.5) . "</span>";
        echo "<a href='post.php?id=" . $row['id'] . "' class='read-more'>Read More</a>";
        echo "</div></div>";
    }
} else {
    echo "<p>No posts found for this category.</p>";
}

// close everything
$stmt->close();
$conn->close();
?>
