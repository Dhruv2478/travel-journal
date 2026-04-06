<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <div style = "text-align: center;" class="form-container">
        <h2>Login</h2>

        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <form action="../php/login_process.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="../html/register.html">Register here</a></p>
    </div>
</body>
</html>
