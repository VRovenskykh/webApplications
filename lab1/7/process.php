<?php
// Перевірка, чи було відправлено форму через POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Отримання даних з форми
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    
    // Перевірка на порожні значення
    if (empty($first_name) || empty($last_name)) {
        echo "Будь ласка, введіть і ім'я, і прізвище.";
    } else {
        // Перевірка на тип даних (припустимо, що це текст)
        if (is_string($first_name) && is_string($last_name)) {
            // Виведення привітання користувачу
            echo "Привіт, " . htmlspecialchars($first_name) . " " . htmlspecialchars($last_name) . "!";
        } else {
            echo "Невірний тип даних. Будь ласка, введіть коректне ім'я та прізвище.";
        }
    }
} else {
    echo "Дані не були відправлені через форму.";
}
?>
