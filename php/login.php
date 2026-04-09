<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body class="login-bg">
    <div class="form-container">
        <h2>Login</h2>

        <?php if(isset($error)) echo "<p class='error-text'>$error</p>"; ?>

        <form action="../php/login_process.php" method="POST">
            <input type="email" name="email" placeholder="Email Address" required>
            
            <input type="password" name="password" placeholder="Password" required>
            
            <div class="button-group">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
        <p>Don't have an account? <a href="../html/register.html">Register here</a></p>
    </div>
</body>
</html>