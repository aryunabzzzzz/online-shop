<?php

class MainController
{
    public function main()
    {
        require_once ('./../View/main.php');
    }

    public function postMain()
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['id'];
        $quantity = 1;

        require_once './../Model/UsersProducts.php';
        $userProduct = new UsersProducts();

        if($userProduct->getOneByUserIdProductId($user_id,$product_id)){
            $userProduct->updateQuantity($user_id, $product_id, $quantity);
        } else {
            $userProduct->create($user_id, $product_id, $quantity);
        }

        echo "Товар $product_id добавлен в количестве $quantity";

        require_once ('./../View/main.php');
    }

}