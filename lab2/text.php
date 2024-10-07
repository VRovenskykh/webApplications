<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем введённый текст
    $logText = trim($_POST['log_text']);

    if (!empty($logText)) {
        $logFile = 'log.txt';
        // Открываем файл в режиме добавления и записываем текст с новой строки
        file_put_contents($logFile, $logText . PHP_EOL, FILE_APPEND);
        echo "Текст успішно додано до log.txt";
    } else {
        echo "Текст не може бути порожнім.";
    }
}

// Отображение содержимого файла log.txt
$logFile = 'log.txt';
if (file_exists($logFile)) {
    echo "<h2>Содержимое log.txt:</h2>";
    echo nl2br(file_get_contents($logFile)); // Преобразуем новые строки в HTML-теги <br>
} else {
    echo "Файл log.txt порожній або не існує.";
}
?>
