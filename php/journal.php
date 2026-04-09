<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Travel Journal - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/journal.css">
    <style>
        .dashboard-container {
            max-width: 900px;
            margin: 80px auto;
            text-align: center;
            padding: 20px;
        }

        .welcome-section {
            margin-bottom: 50px;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            color: #0a3142;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .menu-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            border-color: #f26c4f;
        }

        .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(242, 108, 79, 0.1);
            color: #f26c4f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .menu-card h3 {
            color: #0a3142;
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .menu-card p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <div class="welcome-section">
            <h1>Travel Journal Hub</h1>
            <p>Welcome back! What would you like to do with your memories today?</p>
        </div>

        <div class="card-grid">
            <a href="../html/add_entries.html" class="menu-card">
                <div class="icon-box">
                    <i class="fas fa-pen-fancy"></i>
                </div>
                <h3>Write New Entry</h3>
                <p>Record a new adventure, destination, and your personal experience.</p>
            </a>

            <a href="view_entries.php" class="menu-card">
                <div class="icon-box">
                    <i class="fas fa-th-list"></i>
                </div>
                <h3>View My Journal</h3>
                <p>Browse through all your saved travel stories and generated XML data.</p>
            </a>
        </div>

        <div style="margin-top: 50px;">
            <a href="index.php" class="back-link">
                <i class="fas fa-home"></i> Back to Main Site
            </a>
        </div>
    </div>

</body>
</html>