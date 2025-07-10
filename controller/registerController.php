<?php

$firstName = htmlspecialchars(trim($_POST['firstName']));
$lastName = htmlspecialchars(trim($_POST['lastName']));
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone']));
$password = $_POST['password']; // will hash later
$confirmPassword = $_POST['confirmPassword'];
$birthDate = $_POST['birthDate'];
$gender = htmlspecialchars(trim($_POST['gender']));
$terms = isset($_POST['terms']) ? 1 : 0;

if ($firstName && $lastName && $email && $password && $confirmPassword && $terms) {

}

if ($password != $confirmPassword) {

}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
?>