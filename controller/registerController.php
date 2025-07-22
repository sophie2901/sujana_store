<?php
session_start();
require "../db/conn.php";

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $terms = isset($_POST['terms']);


    if (empty($firstName) || empty($lastName) || empty($email) ||
        empty($password) || empty($confirmPassword)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: /register.php");
        exit();
    }

// Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: /register.php");
        exit();
    }

// Check password match
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: /register.php");
        exit();
    }

// Check terms accepted
    if (!$terms) {
        $_SESSION['error'] = "You must accept the terms and conditions.";
        header("Location: /register.php");
        exit();
    }

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Email already registered.";
        $check->close();
        header("Location: /login.php");
        exit();
    }
    $check->close();


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful!";
        header("Location: /login.php");
    } else {
        $_SESSION['error'] = "Database error: " . $stmt->error;
        header("Location: /register.php");
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: /register.php");
    exit();
}

?>