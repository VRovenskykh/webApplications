<?php

// Настройки подключения к базе данных
$host = 'localhost';
$dbname = 'storelab5';
$user = 'root'; // Замените на вашего пользователя
$password = '123123'; // Замените на ваш пароль

// Функция для подключения к базе данных
function getDBConnection() {
    global $host, $dbname, $user, $password;
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}

class Product {
    public $name;
    public $description;
    protected $price;

    // Конструктор
    public function __construct($name, $price, $description) {
        $this->name = $name;
        $this->setPrice($price);
        $this->description = $description;
    }

    // Метод для валидации и установки цены
    public function setPrice($price) {
        if ($price < 0) {
            throw new Exception("Цена не может быть отрицательной.");
        }
        $this->price = $price;
    }

    // Метод для получения информации о товаре
    public function getInfo() {
        return "Назва: {$this->name}\nЦіна: {$this->price} грн\nОпис: {$this->description}\n";
    }

    // Метод для сохранения товара в базу данных
    public function saveToDB($categoryId) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO products (name, price, description, category_id) VALUES (:name, :price, :description, :category_id)");
        $stmt->execute([
            ':name' => $this->name,
            ':price' => $this->price,
            ':description' => $this->description,
            ':category_id' => $categoryId
        ]);
        echo "Товар {$this->name} добавлен в базу данных.\n";
    }
}

class DiscountedProduct extends Product {
    public $discount;

    public function __construct($name, $price, $description, $discount) {
        parent::__construct($name, $price, $description);
        $this->discount = $discount;
    }

    public function getDiscountedPrice() {
        return $this->price * (1 - $this->discount / 100);
    }

    public function getInfo() {
        $discountedPrice = $this->getDiscountedPrice();
        return parent::getInfo() . "Знижка: {$this->discount}%\nЦіна зі знижкою: {$discountedPrice} грн\n";
    }

    // Метод для сохранения товара со скидкой в базу данных
    public function saveToDB($categoryId) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO products (name, price, description, category_id, discount) VALUES (:name, :price, :description, :category_id, :discount)");
        $stmt->execute([
            ':name' => $this->name,
            ':price' => $this->price,
            ':description' => $this->description,
            ':category_id' => $categoryId,
            ':discount' => $this->discount
        ]);
        echo "Товар со скидкой {$this->name} добавлен в базу данных.\n";
    }
}


class Category {
    public $categoryName;
    private $products = [];

    public function __construct($categoryName) {
        $this->categoryName = $categoryName;
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function displayProducts() {
        echo "Категорія: {$this->categoryName}\n";
        foreach ($this->products as $product) {
            echo $product->getInfo() . "\n";
        }
    }

    // Метод для сохранения категории в базу данных
    public function saveToDB() {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute([':name' => $this->categoryName]);
        echo "Категория {$this->categoryName} добавлена в базу данных.\n";
        return $pdo->lastInsertId();
    }

    // Метод для загрузки товаров категории из базы данных
    public function loadProductsFromDB() {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = (SELECT id FROM categories WHERE name = :name)");
        $stmt->execute([':name' => $this->categoryName]);
        $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($productsData as $productData) {
            if ($productData['discount'] > 0) {
                $product = new DiscountedProduct($productData['name'], $productData['price'], $productData['description'], $productData['discount']);
            } else {
                $product = new Product($productData['name'], $productData['price'], $productData['description']);
            }
            $this->addProduct($product);
        }
    }
}


try {
    // Создаем новую категорию и сохраняем её в базу данных
    $electronics = new Category("Електроніка");
    $categoryId = $electronics->saveToDB();

    // Создаем товары и добавляем их в категорию
    $product1 = new Product("Ноутбук", 15000, "Ноутбук для роботи та ігор");
    $product1->saveToDB($categoryId);

    $discountedProduct1 = new DiscountedProduct("Телевізор", 12000, "Телевізор з 4K роздільною здатністю", 10);
    $discountedProduct1->saveToDB($categoryId);

    // Загружаем все товары из категории и отображаем их
    $electronics->loadProductsFromDB();
    $electronics->displayProducts();

} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage();
}



?>