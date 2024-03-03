<?php

class ProductController
{
    public function addProduct()
    {
        require_once ('./../View/add_product.php');
    }

    public function postAddProduct()
    {
        $errors = $this->validationAddProduct($_POST);
        require_once ('./../View/add_product.php');

        if (empty($errors)){
            $user_id = $_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            require_once './../Model/ProductModel.php';
            $ProductModel = new ProductModel();
            $test = $ProductModel->checkTable($user_id,$product_id);

            if($test){
                $ProductModel->updateTable($user_id, $product_id, $quantity);
            } else {
                $ProductModel->addIntoTable($user_id, $product_id, $quantity);
            }

            echo "Товар $product_id добавлен в количестве $quantity";
        }
    }

    private function validationAddProduct(array $arr):array
    {
        $errors = [];

        if (empty($arr['product_id'])) {
            $errors['product_id'] = 'Поле не должно быть пустым';
        } else {
            $product_id = $arr['product_id'];

            require_once './../Model/ProductModel.php';
            $ProductModel = new ProductModel();

            if (!$ProductModel->getOneById($product_id)){
                $errors['product_id'] = "Продукта с таким id не существует";
            }
        }

        if (empty($arr['quantity'])) {
            $errors['quantity'] = 'Поле не должно быть пустым';
        } else {
            $quantity = $arr['quantity'];
            if ($quantity<=0){
                $errors['quantity'] = 'Количество товара должно быть больше 0';
            }
        }

        return $errors;
    }
}