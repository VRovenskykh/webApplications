<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добро пожаловать</title>
</head>
<body>
    <h1>Добро пожаловать, вы вошли в систему!</h1>
    <p><a href="logout.php">Выйти</a></p>
</body>
</html>
