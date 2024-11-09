<?php
// Проверка имени пользователя в кукис
if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
} else {
    $username = null;
}

// сохранение имени в куки на 7 дней
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = $_POST['username'];
    setcookie('username', $username, time() + (7 * 24 * 60 * 60));
    header("Location: name.php");
}

// удаление куки
if (isset($_POST['delete_cookie'])) {
    setcookie('username', '', time() - 3600);
    header("Location: name.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Приветствие</title>
</head>
<body>
    <?php if ($username): ?>
        <h1>Привет, <?php echo htmlspecialchars($username); ?>!</h1>
        <form method="post">
            <button type="submit" name="delete_cookie">Удалить cookie</button>
        </form>
    <?php else: ?>
        <form method="post">
            <label for="username">Введите ваше имя:</label>
            <input type="text" id="username" name="username" required>
            <button type="submit">Отправить</button>
        </form>
    <?php endif; ?>
</body>
</html>
