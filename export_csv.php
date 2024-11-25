<?php
require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
    exit();
}

// Get filter parameters from the request
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$name = isset($_GET['name']) ? $_GET['name'] : '';
$start_time = isset($_GET['start_time']) ? $_GET['start_time'] : '';
$end_time = isset($_GET['end_time']) ? $_GET['end_time'] : '';
$branch = isset($_GET['branch']) ? $_GET['branch'] : '';

// Prepare SQL query with filters
$sql = "SELECT a.*, b.fullname, b.branch 
        FROM attendance_info a
        LEFT JOIN tbl_admin b ON(a.atn_user_id = b.user_id) 
        WHERE (a.in_time BETWEEN '{$start_date} 00:00:00' AND '{$end_date} 23:59:59')";
if(!empty($name)) {
    $sql .= " AND b.fullname LIKE '%$name%'";
}
if(!empty($start_time)) {
    $sql .= " AND TIME(a.in_time) >= '$start_time'";
}
if(!empty($end_time)) {
    $sql .= " AND TIME(a.out_time) <= '$end_time'";
}
if(!empty($branch)) {
    $sql .= " AND b.branch LIKE '%$branch%'";
}
$sql .= " ORDER BY a.aten_id DESC";

// Execute the query
$info = $obj_admin->manage_all_info($sql);

// Set headers to force download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="attendance_report.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array('No', 'Name', 'In Time', 'Out Time', 'Total Duration', 'Branch'));

// Fetch the data and write to the CSV file
$serial = 1;
while($row = $info->fetch(PDO::FETCH_ASSOC)) {
    $dteStart = new DateTime($row['in_time']);
    $dteEnd = $row['out_time'] == null ? new DateTime('now', new DateTimeZone('Asia/Manila')) : new DateTime($row['out_time']);
    $dteDiff = $dteStart->diff($dteEnd);
    $total_duration = $dteDiff->format("%H:%I:%S");

    fputcsv($output, array(
        $serial++, 
        $row['fullname'], 
        $row['in_time'], 
        $row['out_time'], 
        $total_duration, 
        $row['branch']
    ));
}
fclose($output);
exit;
?>