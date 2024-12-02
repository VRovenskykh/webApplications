<?php
session_start();

// Подключение к базе данных
$dsn = "mysql:host=localhost;dbname=webapp;charset=utf8";
$username = "root";
$password = "123123";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Ошибка подключения к базе данных: " . $e->getMessage()]);
    exit;
}

$action = $_POST['action'] ?? null;

// Регистрация пользователя
if ($action === "register") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверяем, существует ли пользователь
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Користувач з такою електронною поштою вже існує.']);
        exit;
    }

    // Добавляем нового пользователя
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);
    echo json_encode(['success' => true]);
    exit;
}

// Вход пользователя
if ($action === "login") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверяем существование пользователя
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Сохраняем данные пользователя в сессии
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Невірна електронна пошта або пароль.']);
    }
    exit;
}

// Обновление профиля пользователя
if ($action === "updateProfile") {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Ви не авторизовані.']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    // Обновляем данные, только если они были переданы
    if ($username) {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->execute([$username, $userId]);
    }

    if ($password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);
    }

    echo json_encode(['success' => true, 'message' => 'Профіль оновлено.']);
    exit;
}

// Выход пользователя
if ($action === "logout") {
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}

// Если действие не распознано
echo json_encode(['success' => false, 'message' => 'Невідома дія.']);
