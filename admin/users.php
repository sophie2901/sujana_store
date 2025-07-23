<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require "../db/conn.php";
include "./includes/header.php";
?>

<?php
include "./includes/footer.php";
?>
