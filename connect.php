<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
  $fname=$_POST['fname'];
  $ardate=['arrival_date'];
  $email=['email'];
  $Dedate=$_POST['departure_date'];
  $ponumber=$_POST['phone_number'];
  $address=$_POST['address'];
  $distination=$_POST['distination'];
  $spackage=$_POST['special_packages'];
  $adult=$_POST['adult'];
  $child=$_POST['child'];
  $roomtype=$_POST['room-type'];
  $guide=$_POST['guide'];
  $gender=$_POST['gender'];


$con=new mysqli('localhost','root','','package');
if($con){
    //echo"connection successfully";
    $sql="insert into book(Full_name,arrival_date,email,departure_date,phone_number,address,distination,special_package,adult,child,room_type,guide,
    gender)values('$fname','$ardate','$email','$Dedate','$ponumber','$address','$distination','$spackage','$adult','$child','$roomtype','$guide','$gender')";
    $result=mysqli_query($con,$sql);
    if($result){
        echo"data inserted successfully";
    }
    else{
        die(mysqli_error($con));
    }
}else{
    die(mysqli_error($con));
}
}
?>