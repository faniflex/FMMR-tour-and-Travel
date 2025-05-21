<?php
session_start();
if(!isset($_SESSION['reset_user'])) {
    header("Location: forgot_password.php");
    exit();
}

$new_password = "";
$confirm_password = "";
$message = "";
$error = "";

$conn = mysqli_connect("localhost", "root", "", "db");

if(isset($_POST['update_password'])) {
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $fname = $_SESSION['reset_user'];
    
    if($new_password != $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $sql = "UPDATE users SET password='$new_password' WHERE firstname='$fname'";
        
        if(mysqli_query($conn, $sql)) {
            $message = "Password updated successfully! You can now <a href='login.php'>login</a>.";
            unset($_SESSION['reset_user']);
        } else {
            $error = "Error updating password: " . mysqli_error($conn);
        }
    }
}
if(strlen($new_password) < 8) {
    $error = "Password must be at least 8 characters long";
} elseif (!preg_match("/[A-Z]/", $new_password)) {
    $error = "Password must contain at least one uppercase letter";
} elseif (!preg_match("/[0-9]/", $new_password)) {
    $error = "Password must contain at least one number";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
          <form action="reset_password.php" method="post">
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
