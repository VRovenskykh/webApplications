<?php
$host = 'localhost';
$dbname = 'users_db';
$username = 'root'; // имя пользователя БД
$password = '123123'; // пароль для пользователя БД

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
?>
