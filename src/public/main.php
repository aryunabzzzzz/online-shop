<?php

session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: /singin.php");
}

$pdo = new PDO("pgsql:host=db; port=5432; dbname=laravel","root", "root");
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();

if (empty($products)){
    echo 'Товаров нет';
    die();
}
?>

<!DOCTYPE html>
<html>

<?php foreach ($products as $product): ?>

<div class="product-wrap">
    <div class="product-item">
        <img src="<?php echo $product['image']; ?>">
        <div class="product-buttons">
            <a href="" class="button">В корзину</a>
        </div>
    </div>
    <div class="product-title">
        <a href=""><?php echo $product['name']; ?></a>
        <p><?php echo $product['description']; ?></p>
        <span class="product-price"><?php echo $product['price']; ?></span>
    </div>
</div>

<?php endforeach; ?>

</html>

<style>

    body {
        background: #CD5C5C;
        color: #fff;
        font-family: 'Raleway', sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    * {
        box-sizing: border-box;
    }
    .product-wrap {
        width: 300px;
        margin: 0 auto;
        background: white;
        padding: 0 0 20px;
        text-align: center;
        font-size: 14px;
        font-family: Lora;
        text-transform: uppercase;
    }
    .product-item {
        position: relative;
        overflow: hidden;
    }
    .product-wrap img {
        display: block;
        width: 100%;
    }
    .product-buttons {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .8);
        opacity: 0;
        transition: .3s ease-in-out;
    }
    .button {
        text-decoration: none;
        color: #c0a97a;
        font-size: 12px;
        width: 140px;
        height: 40px;
        line-height: 40px;
        position: absolute;
        top: 50%;
        left: 50%;
        border: 2px solid #c0a97a;
        transform: translate(-50%, -50%) scale(0);
        transition: .3s ease-in-out;
    }
    .button:before {
        content: "\f07a";
        font-family: FontAwesome;
        margin-right: 10px;
    }
    .product-item:hover .product-buttons {
        opacity: 1;
    }
    .product-item:hover .button {
        transform: translate(-50%, -50%) scale(1);
    }
    .button:hover {
        background: black;
    }
    .product-title {
        color: #5e5e5e;
    }
    .product-title a {
        text-decoration: none;
        color: #2e2e2e;
        font-weight: 600;
        margin: 15px 0 5px;
        padding-bottom: 7px;
        display: block;
        position: relative;
        transition: .3s ease-in-out;
    }
    .product-title a:after {
        content: "";
        position: absolute;
        width: 40px;
        height: 2px;
        background: #2e2e2e;
        left: 50%;
        margin-left: -20px;
        bottom: 0;
        transition: .3s ease-in-out;
    }
    .product-title a:hover {
        color: #c0a97a;
    }
    .product-title:hover a:after {
        background: #c0a97a;
    }
    .product-price {
        font-size: 20px;
        color: #c0a97a;
        font-weight: 700;
    }

</style>
