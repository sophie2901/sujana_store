<?php
session_start();

require "../db/conn.php";
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'create') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;

            if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = "All required fields must be filled.";
                header("Location: /admin/user-create.php");
                exit();
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Passwords do not match.";
                header("Location: /admin/user-create.php");
                exit();
            }

            $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $check->bind_param("s", $email);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $_SESSION['error'] = "Email already registered.";
                $check->close();
                header("Location: /admin/user-create.php");
                exit();
            }
            $check->close();

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, is_admin) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $first_name, $last_name, $email, $hashed_password, $is_admin);

            if ($stmt->execute()) {
                $_SESSION['success'] = "User created successfully!";
                header("Location: /admin/user-edit.php?id=" . $stmt->insert_id);
            } else {
                $_SESSION['error'] = "Error creating user";
                header("Location: /admin/user-create.php");
            }

            $stmt->close();
            $conn->close();
            exit();
        }
    } elseif ($_GET['action'] == 'update' && isset($_GET['id']) && is_numeric($_GET['id'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_GET['id']);
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Passwords do not match.";
                header("Location: /admin/user-edit.php?id=" . $id);
                exit();
            }

            // Optional password update
            $password = password_hash($password, PASSWORD_BCRYPT);

            // Check if user exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if (!$user) {
                $_SESSION['error'] = "User not found.";
                header("Location: /admin/users.php");
                exit();
            }

            if ($password) {
                $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, is_admin = ? WHERE id = ?");
                $stmt->bind_param("ssssii", $first_name, $last_name, $email, $password, $is_admin, $id);
            } else {
                $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, is_admin = ? WHERE id = ?");
                $stmt->bind_param("sssii", $first_name, $last_name, $email, $is_admin, $id);
            }

            if ($stmt->execute()) {
                $_SESSION['success'] = "User updated successfully!";
            } else {
                $_SESSION['error'] = "User update failed.";
            }

            $stmt->close();
            $conn->close();
            header("Location: /admin/user-edit.php?id=" . $id);
            exit();
        }
    } elseif ($_GET['action'] == 'delete') {
        $id = intval($_POST['id']);

        if ($_SESSION['user_id'] == $id) {
            $_SESSION['error'] = "You cannot delete your own account.";
            header("Location: /admin/users.php");
            exit();
        }

        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "User deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting user.";
        }

        $stmt->close();
        $conn->close();
        header("Location: /admin/users.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: /admin/users.php");
    exit();
}