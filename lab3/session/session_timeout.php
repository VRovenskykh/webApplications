<?php
session_start();

$inactive_time = 300; // секунд
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactive_time)) {
    session_unset();
    session_destroy();
    header("Location: session_login.php");
    exit();
}
$_SESSION['last_activity'] = time();
