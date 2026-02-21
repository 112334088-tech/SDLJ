<?php
// forgot_password.php  –  returns the email on file (demo mode)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));

if (!$username) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter your username first.']);
    exit;
}

$sql    = "SELECT email FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    echo json_encode(['status' => 'error', 'message' => 'No user found. Please register first.']);
    exit;
}

$user = mysqli_fetch_assoc($result);

// In production you would send a real reset email here.
// For demo we just return the email.
echo json_encode([
    'status'  => 'success',
    'message' => 'Password reset link sent to: ' . $user['email']
]);

mysqli_close($conn);
?>
