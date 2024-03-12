<!DOCTYPE html>
<html>
<header>
    <div class="wrap-logo">
        <a href="http://localhost:8080/main" class="logo">Ary's-Online-Shop</a>
    </div>
    <nav>
        <a class="active" href="http://localhost:8080/main">Главная</a>
        <a href="#contact">Выйти</a>
        <a href="http://localhost:8080/cart">
            <img src="https://sun9-75.userapi.com/impg/xdOuULPth-4LPy1maTsdTmt_vliQd304VnYqsA/cBVpvvQPqyU.jpg?size=512x512&quality=96&sign=b3074561b3aa5d6af3e22415dea98233&type=album" width="30" height="30">
        </a>
    </nav>
</header>

<h1>Каталог товаров</h1>

<?php foreach ($products as $product): ?>

    <div class="product-wrap">
        <div class="product-item">
            <img src="<?php echo $product['image']; ?>">
        </div>
        <div class="product-title">
            <a><?php echo $product['name']; ?></a>
            <p><?php echo $product['description']; ?></p>
            <span class="product-price"><?php echo $product['price']; ?></span>
        </div>
        <form action="/add_product" method="POST">
        <div>
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <button class="button"> В корзину </button>
        </div>
        </form>

    </div>



<?php endforeach; ?>



</html>

<style>

    * {box-sizing: border-box;}

    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }

    header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        flex-wrap: wrap;
        background-color: #fff;
        padding: 20px 10px;
    }

    .wrap-logo {
        display: flex;
        align-items: center;

    }

    header a {
        color: #212121;
        padding: 12px;
        text-decoration: none;
        font-size: 18px;
        border-radius: 4px;
    }

    header a.logo {
        font-size: 25px;
        font-weight: bold;
    }

    header a:hover {
        background-color: #CD5C5C;
        color: #212121;
    }

    nav {
        display: flex;
        align-items: center;
    }

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

    .product-price {
        font-size: 20px;
        color: #c0a97a;
        font-weight: 700;
    }

    .button {
        text-decoration: none;
        color: #c0a97a;
        font-size: 12px;
        width: 140px;
        height: 40px;
        border: 2px solid #c0a97a;
    }

    .button:hover {
        background: #2e2e2e;
    }


</style>
