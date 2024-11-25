<?php

use PHPUnit\Framework\TestCase;
use OnlineStore\Product;
use OnlineStore\Cart;
use OnlineStore\Exceptions\ItemOutOfStockException;
use OnlineStore\Exceptions\CartLimitExceededException;

class CartTest extends TestCase {
    public function testAddItem() {
        $product1 = new Product("Laptop", 1000, 5);
        $cart = new Cart();
        $cart->addItem($product1, 2);
        $this->assertEquals(2, $cart->items["Laptop"]["quantity"]);
        $this->assertEquals(3, $product1->getStock());
    }

    public function testAddItemOutOfStockException() {
        $product1 = new Product("Laptop", 1000, 5);
        $cart = new Cart();
        $this->expectException(ItemOutOfStockException::class);
        $cart->addItem($product1, 6);
    }

    public function testAddItemCartLimitExceededException() {
        $product1 = new Product("Laptop", 1000, 5);
        $cart = new Cart();
        for ($i = 0; $i < 20; $i++) {
            $cart->addItem($product1, 1);
        }
        $this->expectException(CartLimitExceededException::class);
        $cart->addItem($product1, 1);
    }

    public function testRemoveItem() {
        $product1 = new Product("Laptop", 1000, 5);
        $cart = new Cart();
        $cart->addItem($product1, 2);
        $cart->removeItem($product1);
        $this->assertArrayNotHasKey("Laptop", $cart->items);
    }

    public function testGetTotal() {
        $product1 = new Product("Laptop", 1000, 5);
        $product2 = new Product("Smartphone", 500, 10);
        $cart = new Cart();
        $cart->addItem($product1, 2);
        $cart->addItem($product2, 1);
        $this->assertEquals(2500, $cart->getTotal());
    }
}