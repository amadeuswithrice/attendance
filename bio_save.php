<?php
// Include the database connection file
include('authentication.php');

// Check if the connection is established
if (!isset($conn)) {
    die(json_encode(array("status" => "error", "message" => "Database connection failed")));
}

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error)));
}

// Get the POST data
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
$biotime = isset($_POST['bio_in']) ? $_POST['bio_in'] : '';
$biodate = isset($_POST['date']) ? $_POST['date'] : '';
$bioexceed = isset($_POST['bio_exceed']) ? $_POST['bio_exceed'] : '';

// Validate data
if (empty($user_id) || empty($fullname) || empty($biotime) || empty($biodate)) {
    echo json_encode(array("status" => "error", "message" => "Incomplete data"));
    exit();
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO tbl_breaks (user_id, fullname, date, bio_in, bio_exceed) VALUES (?, ?, ?, ?, ?)");
if ($stmt === false) {
    echo json_encode(array("status" => "error", "message" => $conn->error));
    exit();
}
$stmt->bind_param("issss", $user_id, $fullname, $biodate, $biotime, $bioexceed);

// Execute the statement
if ($stmt->execute()) {
    $response = array("status" => "success");
} else {
    $response = array("status" => "error", "message" => $stmt->error);
}

// Close statement
$stmt->close();

// Close connection
$conn->close();

// Response
echo json_encode($response);
?>
