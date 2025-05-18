<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
  $fname = $_POST['fname'];
  $ardate = $_POST['arrival_date'];
  $email = $_POST['email'];
  $Dedate = $_POST['departure_date'];
  $ponumber = $_POST['phone_number'];
  $address = $_POST['address'];
  $distination = $_POST['distination'];
  $spackage = $_POST['special_packages'];
  $adult = $_POST['adult'];
  $child = $_POST['child'];
  $roomtype = $_POST['room-type'];
  $guide = $_POST['guide'];
  $gender = $_POST['gender'];

  // Get today's date and time
  $booking_date = date('Y-m-d H:i:s');

  $con = new mysqli('localhost','root','','db');
  if($con){
      $sql = "INSERT INTO book(
          Full_name, arrival_date, email, departure_date, phone_number, address,
          distination, special_package, adult, child, room_type, guide, gender, booking_date
      ) VALUES (
          '$fname','$ardate','$email','$Dedate','$ponumber','$address',
          '$distination','$spackage','$adult','$child','$roomtype','$guide','$gender','$booking_date'
      )";
      
      $result = mysqli_query($con, $sql);
      if($result){
          echo "Data inserted successfully";
      } else {
          die(mysqli_error($con));
      }
  } else {
      die(mysqli_error($con));
  }
}
?>
