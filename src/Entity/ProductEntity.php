<?php

namespace Entity;

class ProductEntity
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private string $image;

    public function __construct(int $id, string $name, string $description, float $price, string $image)
    {
        $this->id = $id;
        $this->name= $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->image;
    }


}