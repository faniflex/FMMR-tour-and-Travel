<?php
session_start();
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
    
    if(mysqli_num_rows($result) > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
        // Store token in database
        $sql = "UPDATE users SET reset_token='$token', reset_expires='$expires' WHERE email='$email'";
        if(mysqli_query($conn, $sql)) {
            // For local development, show the reset link directly
            $reset_link = "http://localhost/your_folder/reset_password.php?token=$token";
            $message = "For local development, use this reset link: <a href='$reset_link'>$reset_link</a><br><br>";
            $message .= "This link will expire in 1 hour.";
        } else {
            $error = "Database error: " . mysqli_error($conn);
        }
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
    <link rel="stylesheet" href="form.css">
</head>
<body>
  <div class="container" style="margin-top: 100px;">
    <div class="title">Reset Password</div>
    <div class="content">
      <form action="forgot_password.php" method="post">
        <?php if($error): ?>
            <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($message): ?>
            <div style="color: green; margin-bottom: 15px;"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>
        
        <div class="button">
          <input type="submit" name="reset_password" value="Get Reset Link">
        </div>
      </form>
      <div style="text-align: center; margin-top: 15px;">
        <a href="login.php">Back to Login</a>
      </div>
    </div>
  </div>
</body>
</html>
