<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $item = $_POST['item'];
    $_SESSION['cart'][] = $item;

    $previous_cart = isset($_COOKIE['previous_cart']) ? json_decode($_COOKIE['previous_cart'], true) : [];
    $previous_cart[] = $item;
    setcookie('previous_cart', json_encode($previous_cart), time() + (7 * 24 * 60 * 60));
    header("Location: cart.php");
}

$previous_purchases = isset($_COOKIE['previous_cart']) ? json_decode($_COOKIE['previous_cart'], true) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Корзина</title>
</head>
<body>
    <h1>Текущая корзина</h1>
    <ul>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <li><?php echo htmlspecialchars($item); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Добавить товар:</h2>
    <form method="post">
        <input type="text" name="item" required>
        <button type="submit" name="add_to_cart">Добавить в корзину</button>
    </form>

    <h1>Предыдущие покупки</h1>
    <ul>
        <?php foreach ($previous_purchases as $item): ?>
            <li><?php echo htmlspecialchars($item); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
