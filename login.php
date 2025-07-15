<?php
include 'config.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = :username AND role = :role");
    $stmt->execute([':username' => $username, ':role' => $role]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $username;
        header("Location: " . ($role == 'receptionist' ? 'index.html' : $role . '.php'));
    } else {
        echo "Invalid credentials!";
    }
}
?>