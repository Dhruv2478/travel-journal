<?php
include '../database/database_connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $type = trim($_POST['type']);
    $category = trim($_POST['category']);
    $region = trim($_POST['region']);
    $excerpt = trim($_POST['excerpt']);
    $description = trim($_POST['description']);
    $rating = floatval($_POST['rating']);
    $author = $_SESSION['username'];
    $author_id = $_SESSION['user_id'];
    
    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        
        // Create uploads directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name = basename($_FILES['image']['name']);
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $new_filename;
        
        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array(strtolower($file_ext), $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = '/travelweb/uploads/' . $new_filename;
            } else {
                $error = "Failed to upload image";
            }
        } else {
            $error = "Invalid file type. Only JPG, PNG, GIF, and WebP are allowed.";
        }
    }
    
    // Insert post into database if no errors
    if (!isset($error)) {
        $sql = "INSERT INTO posts (title, type, category, region, excerpt, description, image, rating, author, author_id, date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssii", $title, $type, $category, $region, $excerpt, $description, $image, $rating, $author, $author_id);
        
        if ($stmt->execute()) {
            $success = "Post created successfully!";
            header("Location: destination.php");
            exit;
        } else {
            $error = "Error creating post: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Destination Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/form.css">
    <style>
        body {
            background: linear-gradient(135deg, #0a3142 0%, #1a5f77 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        h1 {
            color: #0a3142;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #0a3142;
            font-weight: 600;
        }
        
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #f26c4f;
            box-shadow: 0 0 5px rgba(242, 108, 79, 0.3);
        }
        
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .file-upload {
            position: relative;
        }
        
        .file-upload input[type="file"] {
            display: none;
        }
        
        .file-upload-label {
            display: block;
            padding: 12px;
            background: #f5f5f5;
            border: 2px dashed #0a3142;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .file-upload-label:hover {
            background: #0a3142;
            color: white;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        button,
        .cancel-btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        button {
            background: #f26c4f;
            color: white;
        }
        
        button:hover {
            background: #e54d2f;
            transform: translateY(-2px);
        }
        
        .cancel-btn {
            background: #e0e0e0;
            color: #0a3142;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cancel-btn:hover {
            background: #c0c0c0;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-error {
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }
        
        .alert-success {
            background: #efe;
            color: #3c3;
            border-left: 4px solid #3c3;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
            
            .two-column {
                grid-template-columns: 1fr;
            }
            
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-plus-circle"></i> Create Destination Post</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <!-- Title -->
            <div class="form-group">
                <label for="title">Destination Name *</label>
                <input type="text" id="title" name="title" required placeholder="e.g., Paris, Tokyo, Bali">
            </div>
            
            <!-- Type & Category -->
            <div class="two-column">
                <div class="form-group">
                    <label for="type">Type *</label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="Beach">Beach</option>
                        <option value="Mountain">Mountain</option>
                        <option value="City">City</option>
                        <option value="Resort">Resort</option>
                        <option value="Historical">Historical</option>
                        <option value="Nature">Nature</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Culture">Culture</option>
                        <option value="Food & Drink">Food & Drink</option>
                        <option value="Photography">Photography</option>
                    </select>
                </div>
            </div>
            
            <!-- Region -->
            <div class="form-group">
                <label for="region">Region/Country</label>
                <input type="text" id="region" name="region" placeholder="e.g., France, Japan, Indonesia">
            </div>
            
            <!-- Excerpt -->
            <div class="form-group">
                <label for="excerpt">Short Description *</label>
                <textarea id="excerpt" name="excerpt" required placeholder="Brief overview (shown on destination page)"></textarea>
            </div>
            
            <!-- Full Description -->
            <div class="form-group">
                <label for="description">Full Description</label>
                <textarea id="description" name="description" placeholder="Detailed description (shown on post page)"></textarea>
            </div>
            
            <!-- Rating -->
            <div class="form-group">
                <label for="rating">Rating (0-5)</label>
                <input type="number" id="rating" name="rating" min="0" max="5" step="0.1" value="4.5">
            </div>
            
            <!-- Image Upload -->
            <div class="form-group file-upload">
                <label for="image">Upload Image</label>
                <div class="file-upload-label" onclick="document.getElementById('image').click()">
                    <i class="fas fa-cloud-upload-alt"></i> Click to upload or drag image here
                </div>
                <input type="file" id="image" name="image" accept="image/*">
                <small style="color: #666;">JPG, PNG, GIF, or WebP (Max 5MB)</small>
            </div>
            
            <!-- Buttons -->
            <div class="button-group">
                <button type="submit"><i class="fas fa-paper-plane"></i> Publish Post</button>
                <a href="destination.php" class="cancel-btn"><i class="fas fa-times"></i> Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
