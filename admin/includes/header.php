<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: /index.php");
    exit;
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=`device-width`, initial-scale=1.0">
        <title>Admin Panel - Sujana's Store</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="./../../css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="./../../css/style.css">
    </head>

    <body>
    <div class="container-fluid">
        <div class="row vh-100">
<?php include "./includes/sidebar.php"; ?>