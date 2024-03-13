<header>
    <div class="wrap-logo">
        <a href="http://localhost:8080/main" class="logo">Ary's-Online-Shop</a>
    </div>
    <nav>
        <a class="active" href="http://localhost:8080/main">Главная</a>
        <a href="http://localhost:8080/logout">Выйти</a>
        <a href="http://localhost:8080/cart">
            <img src="https://sun9-75.userapi.com/impg/xdOuULPth-4LPy1maTsdTmt_vliQd304VnYqsA/cBVpvvQPqyU.jpg?size=512x512&quality=96&sign=b3074561b3aa5d6af3e22415dea98233&type=album" width="30" height="30">
        </a>
    </nav>
</header>

<div class="row">
    <div class="col-75">
        <div class="container">
            <form action="/order" method="POST">

                <div class="row">
                    <div class="col-50">
                        <h3>Оформление заказа</h3>
                        <label>Фамилия Имя</label>
                        <input type="text" id="fullName" name="fullName">
                        <p><?php echo $errors['fullName'] ?? ''; ?></p>
                        <label>Номер телефона</label>
                        <input type="text" id="phone" name="phone">
                        <p><?php echo $errors['phone'] ?? ''; ?></p>
                        <label>Адрес</label>
                        <input type="text" id="address" name="address">
                        <p><?php echo $errors['address'] ?? ''; ?></p>

                    </div>

                </div>
                <input type="submit" value="Оформить" class="btn">
            </form>
        </div>
    </div>

    <div class="col-25">
        <div class="container">
            <h4>Корзина <span class="price" style="color:white"></span></h4>
            <?php foreach ($cartProducts as $cartProduct): ?>
            <p><a><?php echo $cartProduct['name']; ?></a> <a>  - <?php echo $cartProduct['quantity']; ?> шт</a> <span class="price"><?php echo $cartProduct['price']; ?> ₽ </span> </p>
            <?php endforeach; ?>
            <hr>
            <p>Итого <span class="price" style="color:white"><b><?php echo $totalPrice; ?> ₽</b></span></p>
        </div>
    </div>
</div>

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

    .row {
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
        margin: 0 -16px;
    }

    .col-25 {
        -ms-flex: 25%; /* IE10 */
        flex: 25%;
    }

    .col-50 {
        -ms-flex: 50%; /* IE10 */
        flex: 50%;
    }

    .col-75 {
        -ms-flex: 75%; /* IE10 */
        flex: 75%;
    }

    .col-25,
    .col-50,
    .col-75 {
        padding: 0 16px;
    }

    .container {
        padding: 5px 20px 15px 20px;
        border: 1px solid #fff;
        border-radius: 3px;
    }

    input[type=text] {
        width: 100%;
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    label {
        margin-bottom: 10px;
        display: block;
    }

    .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
    }

    .btn {
        background-color: #B22222;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
    }

    .btn:hover {
        background-color: #DC143C;
    }

    span.price {
        float: right;
        color: #fff;
    }

    /* Адаптивная разметка — когда ширина экрана становится меньше 800px,
    делаем так, чтобы две колонки складывались друг над другом, а не рядом
    друг с другом (и меняем направление — колонка "корзины" будет вверху) */
    @media (max-width: 800px) {
        .row {
            flex-direction: column-reverse;
        }
        .col-25 {
            margin-bottom: 20px;
        }
    }


</style>