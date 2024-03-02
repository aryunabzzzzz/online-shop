<?php

session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: /login");
}
?>

<!DOCTYPE html>
<html>
<body>

<form action="/add_product" method="POST">

    <input id="signup" name="action" type="radio" value="signup">
    <label>ADD PRODUCT</label>

    <div id="wrapper">
        <div id="arrow"></div>
        <input id="product_id" placeholder="Product_id" type="text" name="product_id">
        <p><?php echo $errors['product_id'] ?? ''; ?></p>
        <input id="quantity" placeholder="Quantity" type="text" name="quantity">
        <p><?php echo $errors['quantity'] ?? ''; ?></p>
    </div>
    <button type="submit">
    <span>
      ADD PRODUCT
    </span>
    </button>

</form>

</body>
</html>

<?php
require_once ('./style.php');