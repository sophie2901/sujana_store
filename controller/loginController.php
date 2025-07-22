<?php
session_start();
require "../db/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: /login.php");
        exit();
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'][0] . '.';
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'] == 1;

            if ($user['is_admin'] == 1) {
                header('Location: /admin/dashboard.php');
                exit();
            }

            header("Location: /index.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect email or password.";
            header("Location: /login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Incorrect email or password.";
        header("Location: /login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: /login.php");
    exit();
}