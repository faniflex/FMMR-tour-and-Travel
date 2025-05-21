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
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "db");

$report_type = $_GET['type'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

$stmt = $conn->prepare("SELECT 
    DATE(booking_date) as booking_day,
    distination,
    special_package,
    room_type,
    COUNT(*) as total_bookings,
    SUM(adult) as total_adults,
    SUM(child) as total_children,
    SUM(adult + child) as total_visitors
FROM book
WHERE DATE(booking_date) BETWEEN ? AND ?
GROUP BY distination, special_package, room_type, DATE(booking_date)
ORDER BY booking_day DESC");

$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tour_report_'.date('Y-m-d').'.csv"');

$output = fopen('php://output', 'w');

// CSV headers
fputcsv($output, array(
    'Booking Date', 
    'Destination', 
    'Package', 
    'Room Type',
    'Total Bookings',
    'Total Adults',
    'Total Children',
    'Total Visitors'
));

while($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array(
        $row['booking_day'],
        $row['distination'],
        $row['special_package'],
        $row['room_type'],
        $row['total_bookings'],
        $row['total_adults'],
        $row['total_children'],
        $row['total_visitors']
    ));
}

fclose($output);
exit();
