<?php

namespace Entity;

use Entity\UserEntity;
use Entity\ProductEntity;

class UserProductEntity
{
    private int $id;
    private UserEntity $userEntity;
    private  ProductEntity $productEntity;
    private int $quantity;

    public function __construct(int $id, UserEntity $userEntity, ProductEntity $productEntity, int $quantity)
    {
        $this->id = $id;
        $this->userEntity = $userEntity;
        $this->productEntity = $productEntity;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserEntity(): UserEntity
    {
        return $this->userEntity;
    }

    public function getProductEntity(): ProductEntity
    {
        return $this->productEntity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

}