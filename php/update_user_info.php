<?php
require_once '../config/connect.php';

header('Content-Type: application/json');

// Get POST data (support both JSON and form-urlencoded)
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? $_SERVER["CONTENT_TYPE"] : "";

if (strpos($contentType, 'application/json') !== false) {
    $data = json_decode(file_get_contents('php://input'), true);
} else {
    $data = $_POST;
}

if (!isset($data['field']) || !isset($data['value']) || !isset($data['username'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

// Map field names to database columns
$field_map = [
    'username' => 'username',
    'email' => 'user_email',
    'address' => 'user_address',
    'phone' => 'user_phone'
];

$field = $data['field'];
$value = $data['value'];
$username = $data['username'];

if (!isset($field_map[$field])) {
    echo json_encode(['success' => false, 'message' => 'Invalid field']);
    exit;
}

// Update the database
$update_query = "UPDATE user_table SET " . $field_map[$field] . " = ? WHERE username = ?";
$stmt = mysqli_prepare($con, $update_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $value, $username);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Prepare failed']);
}
?>
