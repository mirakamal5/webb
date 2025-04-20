<?php
session_start();
require_once 'config.php';

// Check if data is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and clean data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']); // checkbox

    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill all fields.";
        header("Location: login.php");
        exit();
    }

    // Fetch user by email
    $stmt = $con->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch();

        // Verify password
        if (password_verify($password, $user['password_hash'])) {
            // Password correct → Start session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            if ($remember) {
                // Set cookies if remember me is checked (7 days)
                setcookie('user_id', $user['id'], time() + (86400 * 7), "/");
                setcookie('username', $user['username'], time() + (86400 * 7), "/");
                setcookie('email', $user['email'], time() + (86400 * 7), "/");
            }

            $_SESSION['success'] = "Login successful! Welcome, " . htmlspecialchars($user['username']) . ".";
            header("Location: index.php");
            file_put_contents(__DIR__ . '/session_debug.txt', print_r([
                'session_id' => session_id(),
                'session_before_redirect' => $_SESSION
            ], true));
            
            exit();
            // Redirect if needed:
            // header("Location: dashboard.php");
            // exit();
        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: login.php");
            exit();

        }
    } else {
        $_SESSION['error'] = "User not found.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid Request.";
    header("Location: login.php");
    exit();
}
?>
