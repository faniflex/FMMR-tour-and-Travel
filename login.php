<?php
$fname="";
$password="";
$err="";

//database connection
$conn=mysqli_connect("localhost","root","","db");
if(isset($_POST['LOGIN'])){
    $fname=mysqli_real_escape_string($conn,$_POST['fname']);
    $password=mysqli_real_escape_string($conn,$_POST['password']);

    $sql="select * from users where firstname='".$fname."'and password='".$password."' limit 1";
    $result= mysqli_query($conn,$sql);

    if(empty($fname)){
        $err="username is required";
    }else if(empty($password)){
        $err="password is required";
    }else if(mysqli_num_rows($result)){
        header('location: orginalweb.html');
    }else{
        $err="username or password is incorrect";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login system</title>
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>
    <div class="box">
        <h1>LOGIN Here</h1>
        <div class="err">
            <?php echo $err; ?>
        </div>
        <form action="login.php" method="post">
            <input type="text" name="fname" id="" placeholder="Enter Username">
            <input type="password" name="password" id="" placeholder="Enter password">
            <input type="submit" value="LOGIN" name="LOGIN">
            Not yet a member? <a href="signup.php" style="color:yellow;">SIGNUP</a>

        </form>
    </div>
    
    
</body>
</html>