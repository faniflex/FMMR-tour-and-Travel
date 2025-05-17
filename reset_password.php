<?php
$new_password = "";
$confirm_password = "";
$message = "";
$error = "";

// Database connection
$conn = mysqli_connect("localhost", "root", "", "db");

if(isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    
    // Check if token is valid and not expired
    $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_expires > NOW() LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) == 0) {
        $error = "Invalid or expired token. Please request a new password reset link.";
    }
    
    if(isset($_POST['update_password'])) {
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        
        if($new_password != $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            // Update password and clear reset token
            $user = mysqli_fetch_assoc($result);
            $email = $user['email'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            $sql = "UPDATE users SET password='$hashed_password', reset_token=NULL, reset_expires=NULL WHERE email='$email'";
            if(mysqli_query($conn, $sql)) {
                $message = "Password updated successfully. You can now <a href='login.php'>login</a> with your new password.";
            } else {
                $error = "Error updating password: " . mysqli_error($conn);
            }
        }
    }
} else {
    $error = "No token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        .reset-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 400px;
            text-align: center;
        }
        .reset-box h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .reset-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .reset-box input[type="submit"] {
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
        .reset-box input[type="submit"]:hover {
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
    </style>
</head>
<body>
    <div class="reset-box">
        <h1>Set a New Password</h1>
        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php else: ?>
            <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
                <input type="password" name="new_password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                <input type="submit" name="update_password" value="Update Password">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
