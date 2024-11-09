<?php
session_start();

// Проверка, если пользователь уже вошел
if (isset($_SESSION['user'])) {
    header("Location: session_home.php");
    exit();
}

// Если отправлена форма, сохраняем логин в сессии
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $_SESSION['user'] = $_POST['login'];
    header("Location: session_home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <form method="post">
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" required>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
