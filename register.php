<?php
// register.php  –  handles registration form submission
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require 'db.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Get & sanitize inputs
$username        = trim(mysqli_real_escape_string($conn, $_POST['username']        ?? ''));
$email           = trim(mysqli_real_escape_string($conn, $_POST['email']           ?? ''));
$mobile          = trim(mysqli_real_escape_string($conn, $_POST['mobile']          ?? ''));
$password        = $_POST['password']        ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// --- Validation ---
if (!$username || !$email || !$mobile || !$password || !$confirmPassword) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address!']);
    exit;
}

if (!preg_match('/^[0-9]{10}$/', $mobile)) {
    echo json_encode(['status' => 'error', 'message' => 'Mobile number must be 10 digits!']);
    exit;
}

if (strlen($password) < 5) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 5 characters!']);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match!']);
    exit;
}

// Check if username already exists
$check = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username' OR email = '$email'");
if (mysqli_num_rows($check) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username or Email already registered!']);
    exit;
}

// Hash password (secure)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$sql = "INSERT INTO users (username, email, mobile, password)
        VALUES ('$username', '$email', '$mobile', '$hashedPassword')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please login.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Registration failed. Try again!']);
}

mysqli_close($conn);
?>
