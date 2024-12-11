<?php

namespace OnlineStore;

use OnlineStore\Exceptions\OutOfStockException;

class Product
{
    private string $name;
    private float $price;
    private int $stock;

    public function __construct(string $name, float $price, int $stock)
    {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function reduceStock(int $quantity)
    {
        if ($this->stock < $quantity) {
            throw new OutOfStockException("Недостаточно товара на складе {$this->name}");
        }
        $this->stock -= $quantity;
    }
}
