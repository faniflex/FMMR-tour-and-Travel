<?php
session_start();

$error = '';
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Change these to your preferred admin credentials
    if($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true;
        header("Location: reports.php");
        exit();
    } else {
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
