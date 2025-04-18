<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // 1. Basic empty field validation
    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill all fields.";
        header("Location: login.php");
        exit();
    }

    // 2. Email format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: login.php");
        exit();
    }

    // 3. Username length validation
    if (strlen($username) < 3) {
        $_SESSION['error'] = "Username must be at least 3 characters.";
        header("Location: login.php");
        exit();
    }

    // 4. Password strength validation
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6) {
        $_SESSION['error'] = "Password must be strong (at least 6 characters, including uppercase, lowercase, number, and special character).";
        header("Location: login.php");
        exit();
    }

    // 5. Check if email already exists
    $stmt = $con->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email already registered.";
        header("Location: login.php");
        exit();
    }

    // 6. Insert new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert = $con->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $insert->bindParam(':username', $username);
    $insert->bindParam(':email', $email);
    $insert->bindParam(':password', $hashed_password);
    $insert->execute();

    $_SESSION['success'] = "Registration successful! Please login now.";
    header("Location: login.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid Request.";
    header("Location: login.php");
    exit();
}
?>
