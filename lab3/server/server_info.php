<?php
// информация о сервере и клиенте
$client_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$current_script = $_SERVER['PHP_SELF'];
$request_method = $_SERVER['REQUEST_METHOD'];
$file_path = __FILE__;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сервер</title>
</head>
<body>
    
    <h1>Информация о сервере</h2>

    <ul>
        <li><strong>Айпи-адрес клиента:</strong> <?php echo htmlspecialchars($client_ip); ?></li>
        <li><strong>Браузер:</strong> <?php echo htmlspecialchars($user_agent); ?></li>
        <li><strong>Текущий скрипт:</strong> <?php echo htmlspecialchars($current_script); ?></li>
        <li><strong>Метод запроса:</strong> <?php echo htmlspecialchars($request_method); ?></li>
        <li><strong>Путь к файлу на сервере:</strong> <?php echo htmlspecialchars($file_path); ?></li>
    </ul>

</body>
</html>
