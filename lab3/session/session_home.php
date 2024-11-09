<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: session_login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: session_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Добро пожаловать</title>
</head>
<body>
    <h1>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
    <form method="post">
        <button type="submit" name="logout">Выйти</button>
    </form>
</body>
</html>
