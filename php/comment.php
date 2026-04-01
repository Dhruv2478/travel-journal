<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $post_id = trim($_POST['post_id']);
    $category = trim($_POST['category']);
    $rating = (int)$_POST['rating'];
    $description = trim($_POST['description']);

    $sql = "INSERT INTO comment (post_id, name, category, rating, description)
            VALUES ('$post_id', '$name', '$category', '$rating', '$description')";

    if($conn->query($sql)) {
        // redirect destination: your post page
        $redirect_url = "post.php?id=" . $post_id;
        ?>
        
        <!DOCTYPE html>
        <html>
        <head>
            <title>Comment Submitted</title>
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
