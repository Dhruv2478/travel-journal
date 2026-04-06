<?php
include '../database/database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id === 0) {
        die("No entry selected.");
    }

    $xml = simplexml_load_file("../xml/my_entries.xml");
    $entry = null;
    foreach ($xml->entry as $e) {
        if ((int)$e->id === $id) {
            $entry = $e;
            break;
        }
    }

    if (!$entry) {
        die("Entry not found.");
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title><?php echo $entry->title; ?></title>
        <link rel="stylesheet" type="text/css" href="../css/journal.css"/>
    </head>
    <body>
        <div class="container">
            <h2><?php echo $entry->title; ?></h2>
            <p><?php echo $entry->date; ?></p>
            <p><?php echo $entry->location; ?></p>
            <img src="<?php echo $entry->image; ?>" alt="<?php echo $entry->title; ?>" width="300"/>
            <p><?php echo $entry->content; ?></p>

            <h3>Leave a Comment</h3>
            <form method="POST" action="post.php">
                <input type="hidden" name="post_id" value="<?php echo $id; ?>"/>

                <label>Name:</label>
                <input type="text" name="name" required/><br/>

                <label>Category:</label>
                <input type="text" name="category"/><br/>

                <label>Rating (1-5):</label>
                <input type="number" name="rating" min="1" max="5" required/><br/>

                <label>Comment:</label>
                <textarea name="description" required></textarea><br/>

                <button type="submit">Submit</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $post_id = trim($_POST['post_id']);
    $category = trim($_POST['category']);
    $rating = (int)$_POST['rating'];
    $description = trim($_POST['description']);

    $sql = "INSERT INTO comment (post_id, name, category, rating, description)
            VALUES ('$post_id', '$name', '$category', '$rating', '$description')";

    if($conn->query($sql)) {
        $redirect_url = "post.php?id=" . $post_id;
        ?>
        
        <!DOCTYPE html>
        <html>
        <head>
            <title>Comment Submitted</title>
            <link rel="stylesheet" type="text/css" href="/travel-journal/css/journal.css"/>
            <meta http-equiv="refresh" content="3;url=<?= $redirect_url ?>">
            <style>
                body {
                    background: #f4f8ff;
                    font-family: Arial, sans-serif;
                    display: flex;
                    height: 100vh;
                    justify-content: center;
                    align-items: center;
                }
                .box {
                    background: white;
                    padding: 30px 40px;
                    border-radius: 12px;
                    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
                    text-align: center;
                }
                h2 {
                    color: #2b6cb0;
                }
                .btn {
                    margin-top: 20px;
                    background: #2b6cb0;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 6px;
                    cursor: pointer;
                    transition: 0.3s;
                    text-decoration: none;
                }
                .btn:hover {
                    background: #1e4f80;
                }
                .small {
                    margin-top: 8px;
                    font-size: 14px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class="box">
                <h2>✅ Comment Posted!</h2>
                <p>Thank you for sharing your thoughts.</p>

                <a href="<?= $redirect_url ?>" class="btn">Back to Post</a>
                <p class="small">Redirecting in 3 seconds...</p>
            </div>
        </body>
        </html>

        <?php
        exit; // important to stop processing

    } else {
        echo "Error: " . $conn->error;
    }
}
?>
