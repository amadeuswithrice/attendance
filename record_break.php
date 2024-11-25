<?php
session_start();
date_default_timezone_set('Asia/Manila');

require_once 'authentication.php';
//require_once 'classes/admin_class.php'; // Adjust the path as needed

$admin = new Admin_Class();

if (!isset($_SESSION['admin_id'])) {
    echo "User is not logged in or session variables are not set.";
    exit;
}

$user_id = $_SESSION['admin_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['break_duration']) && isset($_POST['break_type'])) {
    $break_duration = $_POST['break_duration'];
    $break_type = $_POST['break_type']; // Get the break type
    
    try {
        $admin->beginTransaction();

        // Calculate break start and end times
        $break_start_time = date('Y-m-d H:i:s'); // Get the current timestamp in MySQL format
        $break_end_time = date('Y-m-d H:i:s', strtotime("+$break_duration minutes")); // Calculate end time by adding break duration to start time

        // Insert break record into the database along with the break type
        $sql = "INSERT INTO break_info (br_user_id, break_start_time, break_end_time, break_type) VALUES (:user_id, :start_time, :end_time, :break_type)";
        $stmt = $admin->db->prepare($sql); // Assuming $admin->db is your PDO connection
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':start_time', $break_start_time);
        $stmt->bindParam(':end_time', $break_end_time);
        $stmt->bindParam(':break_type', $break_type); // Bind the break type parameter
        $stmt->execute();

        $admin->commit();

        // Calculate and return remaining break time in minutes
        $remaining_time = ($break_end_time - time()) / 60; // Convert remaining time to minutes
        echo $remaining_time;
    } catch (Exception $e) {
        $admin->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Invalid request.";
}
?>
