<?php

namespace OnlineStore;

class Product {
    private $name;
    private $price;
    private $stock;

    public function __construct($name, $price, $stock) {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getStock() {
        return $this->stock;
    }

    public function reduceStock($quantity) {
        if ($this->stock < $quantity) {
            throw new Exceptions\OutOfStockException("Недостаточно товара на складе {$this->name}");
        }
        $this->stock -= $quantity;
    }
}
