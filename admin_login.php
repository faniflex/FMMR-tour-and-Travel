<?php
session_start();

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if(isset($_POST['login'])) {
    // Add delay if too many attempts
    if ($_SESSION['login_attempts'] >= 3) {
        sleep(2); // 2 second delay
    }
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Use password_hash() in production instead of plain text
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT); // Store this in a config file in production
    
    if($username === 'admin' && password_verify($password, $hashed_password)) {
        $_SESSION['admin'] = true;
        $_SESSION['login_attempts'] = 0; // Reset attempts
        header("Location: reports.php");
        exit();
    } else {
        $_SESSION['login_attempts']++;
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="form.css">
    <style>
        .login-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .login-title {
            text-align: center;
            margin-bottom: 30px;
            color: #9b59b6;
        }
        .login-error {
            color: red;
            text-align: center;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">Tour System Admin</h1>
        <?php if($error): ?>
            <div class="login-error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="input-box">
                <span class="details">Username</span>
                <input type="text" name="username" required>
            </div>
            <div class="input-box">
                <span class="details">Password</span>
                <input type="password" name="password" required>
            </div>
            <div class="button">
                <input type="submit" name="login" value="Login">
            </div>
        </form>
    </div>
</body>
</html>
