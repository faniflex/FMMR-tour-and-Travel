<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "db");

// Report parameters
$report_type = isset($_GET['type']) ? $_GET['type'] : 'monthly';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');

if($report_type == 'weekly') {
    $title = "Weekly Booking Report";
    $end_date = date('Y-m-d', strtotime($start_date . ' + 6 days'));
} else {
    $title = "Monthly Booking Report";
}

// Main report query
$query = "SELECT 
            DATE(booking_date) as booking_day,
            distination,
            special_package,
            room_type,
            COUNT(*) as total_bookings,
            SUM(adult) as total_adults,
            SUM(child) as total_children,
            SUM(adult + child) as total_visitors
          FROM book
          WHERE DATE(booking_date) BETWEEN '$start_date' AND '$end_date'
          GROUP BY distination, special_package, room_type, DATE(booking_date)
          ORDER BY booking_day DESC";

$result = mysqli_query($conn, $query);
$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Summary statistics
$summary_query = "SELECT 
                   COUNT(*) as total_bookings,
                   SUM(adult) as total_adults,
                   SUM(child) as total_children,
                   SUM(adult + child) as total_visitors,
                   GROUP_CONCAT(DISTINCT distination) as destinations
                 FROM book
                 WHERE DATE(booking_date) BETWEEN '$start_date' AND '$end_date'";
$summary_result = mysqli_query($conn, $summary_query);
$summary = mysqli_fetch_assoc($summary_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tour Booking Reports</title>
    <link rel="stylesheet" href="form.css">
    <style>
        .report-container { max-width: 1200px; margin: 30px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 10px rgba(0,0,0,0.1); }
        .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
        .report-title { font-size: 24px; color: #333; }
        .report-period { font-size: 16px; color: #666; }
        .report-actions { display: flex; gap: 10px; }
        .btn { padding: 8px 15px; background: linear-gradient(135deg, #71b7e6, #9b59b6); color: white; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn:hover { background: linear-gradient(-135deg, #71b7e6, #9b59b6); }
        .summary-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .summary-card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .summary-card h3 { margin-top: 0; color: #555; font-size: 16px; }
        .summary-card p { font-size: 24px; margin: 10px 0; color: #9b59b6; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #9b59b6; color: white; }
        tr:hover { background-color: #f5f5f5; }
        .date-selector { background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .date-selector form { display: flex; gap: 15px; align-items: center; }
        .date-selector label { font-weight: 500; }
        .no-data { text-align: center; padding: 30px; color: #666; font-style: italic; }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <div>
                <h1 class="report-title"><?= $title ?></h1>
                <p class="report-period"><?= date('M j, Y', strtotime($start_date)) ?> - <?= date('M j, Y', strtotime($end_date)) ?></p>
            </div>
            <div class="report-actions">
                <a href="reports.php?type=weekly" class="btn">Weekly</a>
                <a href="reports.php?type=monthly" class="btn">Monthly</a>
                <a href="export_report.php?type=<?= $report_type ?>&start_date=<?= $start_date ?>&end_date=<?= $end_date ?>" class="btn">Export</a>
                <button onclick="window.print()" class="btn">Print</button>
            </div>
        </div>

        <div class="date-selector">
            <form method="GET" action="reports.php">
                <input type="hidden" name="type" value="<?= $report_type ?>">
                <label>From:</label>
                <input type="date" name="start_date" value="<?= $start_date ?>" required>
                <label>To:</label>
                <input type="date" name="end_date" value="<?= $end_date ?>" required>
                <button type="submit" class="btn">Apply</button>
            </form>
        </div>

        <div class="summary-cards">
            <div class="summary-card">
                <h3>Total Bookings</h3>
                <p><?= $summary['total_bookings'] ?></p>
            </div>
            <div class="summary-card">
                <h3>Total Adults</h3>
                <p><?= $summary['total_adults'] ?></p>
            </div>
            <div class="summary-card">
                <h3>Total Children</h3>
                <p><?= $summary['total_children'] ?></p>
            </div>
            <div class="summary-card">
                <h3>Total Visitors</h3>
                <p><?= $summary['total_visitors'] ?></p>
            </div>
        </div>

        <?php if(count($bookings) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Destination</th>
                    <th>Package</th>
                    <th>Room Type</th>
                    <th>Bookings</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bookings as $booking): ?>
                <tr>
                    <td><?= date('M j, Y', strtotime($booking['booking_day'])) ?></td>
                    <td><?= $booking['distination'] ?></td>
                    <td><?= $booking['special_package'] ?></td>
                    <td><?= $booking['room_type'] ?></td>
                    <td><?= $booking['total_bookings'] ?></td>
                    <td><?= $booking['total_adults'] ?></td>
                    <td><?= $booking['total_children'] ?></td>
                    <td><?= $booking['total_visitors'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-data">
            <p>No bookings found for the selected period</p>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
