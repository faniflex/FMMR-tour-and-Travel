<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// when catching errors
if(!$result) {
    error_log("Database error: " . mysqli_error($conn));
    die("An error occurred. Please try again later.");
}

session_start();
$fname = "";
$birthdate = "";
$message = "";
$error = "";

$conn = mysqli_connect("localhost", "root", "", "db");

if(isset($_POST['verify_user'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
    
    $sql = "SELECT * FROM users WHERE firstname='$fname' AND birthdate='$birthdate' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $_SESSION['reset_user'] = $fname;
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "No account found with those details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
        
        <div class="input-box">
            <span class="details">Username</span>
            <input type="text" name="fname" placeholder="Enter your username" required>
        </div>
        
        <div class="input-box">
            <span class="details">Birthdate</span>
            <input type="date" name="birthdate" required>
        </div>
        
        <div class="button">
          <input type="submit" name="verify_user" value="Verify Identity">
        </div>
      </form>
      <div style="text-align: center; margin-top: 15px;">
        <a href="login.php">Back to Login</a>
      </div>
    </div>
  </div>
</body>
</html>
