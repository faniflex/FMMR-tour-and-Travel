<?php
session_start();
$new_password = "";
$confirm_password = "";
$message = "";
$error = "";

// Database connection
$conn = mysqli_connect("localhost", "root", "", "db");

if(isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    
    // Verify token and check expiration
    $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_expires > NOW() LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) == 0) {
        $error = "Invalid or expired token. Please request a new password reset link.";
    } else {
        $user = mysqli_fetch_assoc($result);
        
        if(isset($_POST['update_password'])) {
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
            
            if($new_password != $confirm_password) {
                $error = "Passwords do not match.";
            } else {
                // Update password and clear reset token
                $email = $user['email'];
                $sql = "UPDATE users SET password='$new_password', reset_token=NULL, reset_expires=NULL WHERE email='$email'";
                
                if(mysqli_query($conn, $sql)) {
                    $message = "Password updated successfully! You can now <a href='login.php'>login</a> with your new password.";
                } else {
                    $error = "Error updating password: " . mysqli_error($conn);
                }
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
    <link rel="stylesheet" href="form.css">
</head>
<body>
  <div class="container" style="margin-top: 100px;">
    <div class="title">Set New Password</div>
    <div class="content">
      <?php if($error): ?>
          <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
      <?php elseif($message): ?>
          <div style="color: green; margin-bottom: 15px;"><?php echo $message; ?></div>
      <?php else: ?>
          <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="post">
            <div class="input-box">
                <span class="details">New Password</span>
                <input type="password" name="new_password" placeholder="Enter new password" required>
            </div>
            
            <div class="input-box">
                <span class="details">Confirm Password</span>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            </div>
            
            <div class="button">
              <input type="submit" name="update_password" value="Update Password">
            </div>
          </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
