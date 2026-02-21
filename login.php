<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

$username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill all fields!']);
    exit;
}


$sql    = "SELECT id, username, email, password FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) === 0) {
    echo json_encode(['status' => 'error', 'message' => 'No user found. Please register first.']);
    exit;
}

$user = mysqli_fetch_assoc($result);

if (password_verify($password, $user['password'])) {

    $_SESSION['user_id']  = $user['id'];
    $_SESSION['username'] = $user['username'];

    mysqli_query($conn, "INSERT INTO login_logs (user_id) VALUES ('{$user['id']}')");

    echo json_encode([
        'status'   => 'success',
        'message'  => 'Login successful!',
        'username' => $user['username']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid username or password!']);
}

mysqli_close($conn);
?>
