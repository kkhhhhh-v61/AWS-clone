<?php
require_once '../config/connect.php';

header('Content-Type: application/json');

// Get POST data
$data = $_POST;

if (!isset($data['field']) || !isset($data['value']) || !isset($data['admin_id'])) {
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
$admin_id = $data['admin_id'];

if (!isset($field_map[$field])) {
    echo json_encode(['success' => false, 'message' => 'Invalid field']);
    exit;
}

// Update the database
$update_query = "UPDATE user_table SET " . $field_map[$field] . " = ? WHERE user_id = ?";
$stmt = mysqli_prepare($con, $update_query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "si", $value, $admin_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare query']);
}
?>
