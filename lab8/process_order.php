<?php

// Функция для отправки запросов к API Новой Почты
function sendRequest($data) {
    $ch = curl_init('https://api.novaposhta.ua/v2.0/json/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Проверка данных из формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderNumber = $_POST['order_number'];
    $weight = $_POST['weight'];
    $cityRef = $_POST['city'];
    $deliveryMethod = $_POST['delivery_method'];
    $warehouseRef = $_POST['warehouse'];

    // Проверка корректности данных
    if (empty($orderNumber) || empty($weight) || empty($cityRef) || empty($deliveryMethod) || empty($warehouseRef)) {
        die("Помилка: Всі поля обов'язкові для заповнення.");
    }

    // Сохранение данных в базу данных
    $conn = new mysqli('localhost', 'root', '', 'nova_poshta');
    if ($conn->connect_error) {
        die("Помилка підключення до бази даних: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO orders (order_number, weight, city_ref, delivery_method, warehouse_ref) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sdsss', $orderNumber, $weight, $cityRef, $deliveryMethod, $warehouseRef);

    if ($stmt->execute()) {
        echo "Замовлення успішно збережено!";
    } else {
        echo "Помилка збереження замовлення: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
