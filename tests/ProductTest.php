<?php

use PHPUnit\Framework\TestCase;
use OnlineStore\Product;
use OnlineStore\Exceptions\OutOfStockException;

class ProductTest extends TestCase {
    public function testGetName() {
        $product = new Product("Laptop", 1000, 5);
        $this->assertEquals("Laptop", $product->getName());
    }

    public function testGetPrice() {
        $product = new Product("Laptop", 1000, 5);
        $this->assertEquals(1000, $product->getPrice());
    }

    public function testGetStock() {
        $product = new Product("Laptop", 1000, 5);
        $this->assertEquals(5, $product->getStock());
    }

    public function testReduceStock() {
        $product = new Product("Laptop", 1000, 5);
        $product->reduceStock(2);
        $this->assertEquals(3, $product->getStock());
    }

    public function testReduceStockException() {
        $product = new Product("Laptop", 1000, 5);
        $this->expectException(OutOfStockException::class);
        $product->reduceStock(6);
    }
}