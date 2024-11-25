<?php
include ('authentication.php');

// Get data sent via AJAX
$secnd_in = $_POST['secnd_in'];
$secnd_exceed = $_POST['secnd_exceed'];
$date = $_POST['date'];

// Prepare and execute SQL statement
$sql = "INSERT INTO tbl_break_second (user_id, fullname, date, secnd_in, secnd_exceed)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $user_id, $fullname, $date, $secnd_in, $secnd_exceed);

// Assuming user_id and fullname are already defined or can be fetched from session data
$user_id = 1;
$fullname = "name";

if ($stmt->execute()) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
