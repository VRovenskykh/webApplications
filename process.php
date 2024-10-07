<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Папка для загрузки файлов
    $target_dir = "uploads/";

    // Получаем информацию о загружаемом файле
    $file = $_FILES['file'];
    $fileName = basename($file['name']); // Оригинальное имя файла
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Расширение файла

    // Полный путь к файлу
    $target_file = $target_dir . $fileName;

    // Проверка типа файла и других условий
    $fileSize = $file['size'];
    $allowed_types = ['jpg', 'jpeg', 'png'];
    $max_size = 2 * 1024 * 1024; // 2 МБ

    if (in_array($fileExtension, $allowed_types) && $fileSize <= $max_size) {
        // Проверяем, существует ли уже файл с таким именем
        if (file_exists($target_file)) {
            // Если файл существует, создаём уникальное имя с помощью времени (timestamp)
            $uniqueFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.' . $fileExtension;
            $target_file = $target_dir . $uniqueFileName;

            echo "Файл с таким именем уже существует. Было создано уникальное имя файла: $uniqueFileName<br>";
        } else {
            $uniqueFileName = $fileName; // Оставляем оригинальное имя, если файла нет
        }

        // Перемещаем файл в папку uploads
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            echo "Файл успешно загружен!<br>";
            echo "Оригинальное имя файла: " . htmlspecialchars($uniqueFileName) . "<br>";
            echo "Тип файла: " . $fileExtension . "<br>";
            echo "Размер файла: " . round($fileSize / 1024, 2) . " КБ<br>";
            
            // Ссылка для скачивания файла
            echo "<a href='$target_file' download>Скачать файл</a>";
        } else {
            echo "Ошибка при перемещении файла.";
        }
    } else {
        echo "Недопустимый тип файла или превышен размер.";
    }
}
?>
