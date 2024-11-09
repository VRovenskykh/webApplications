<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: welcome.php");
        exit;
    } else {
        echo "Неверное имя пользователя или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>
    <form action="login.php" method="post">
        <label>Имя пользователя: <input type="text" name="username" required></label><br>
        <label>Пароль: <input type="password" name="password" required></label><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
