<?php
// Директория для хранения загруженных файлов
$directory = 'uploads/';

// Проверяем, что папка существует
if (!is_dir($directory)) {
    echo "Папка 'uploads' не існує.";
    exit;
}

// Получаем список файлов в директории
$files = scandir($directory);
$files = array_diff($files, array('.', '..')); // Исключаем системные файлы

if (!empty($files)) {
    echo "<ul>";
    foreach ($files as $file) {
        // Проверяем, что это файл, а не директория
        if (is_file($directory . $file)) {
            echo "<li><a href='$directory$file' download>$file</a></li>";
        }
    }
    echo "</ul>";
} else {
    echo "Файли відсутні.";
}
?>
