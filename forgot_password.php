<?php
$email = "";
$message = "";
$error = "";

// Database connection
$conn = mysqli_connect("localhost", "root", "", "db");

if(isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
        // Store token in database
        $sql = "UPDATE users SET reset_token='$token', reset_expires='$expires' WHERE email='$email'";
        mysqli_query($conn, $sql);
        
        // In a real application, you would send an email with a reset link
        // For this example, we'll just show the reset link
        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
        $message = "Password reset link: <a href='$reset_link'>$reset_link</a> (This link expires in 1 hour)";
    } else {
        $error = "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .forgot-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        .forgot-box h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .forgot-box input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .forgot-box input[type="submit"] {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 10px;
        }
        .forgot-box input[type="submit"]:hover {
            background: linear-gradient(-135deg, #71b7e6, #9b59b6);
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .message {
            color: green;
            margin: 10px 0;
        }
        .back-to-login {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="forgot-box">
        <h1>Reset Your Password</h1>
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php else: ?>
            <form action="forgot_password.php" method="post">
                <p>Enter your email address and we'll send you a link to reset your password.</p>
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="submit" name="reset_password" value="Send Reset Link">
            </form>
        <?php endif; ?>
        <div class="back-to-login">
            <a href="login.php">Back to Login</a>
        </div>
    </div>
</body>
</html>
