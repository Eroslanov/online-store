<?php

require 'vendor/autoload.php';

use OnlineStore\Product;
use OnlineStore\Cart;
use OnlineStore\Checkout;
use OnlineStore\Exceptions\ItemOutOfStockException;
use OnlineStore\Exceptions\CartLimitExceededException;
use OnlineStore\Exceptions\InsufficientFundsException;
use OnlineStore\Exceptions\PaymentGatewayException;

// продукты
$product1 = new Product("Laptop", 1000, 5);
$product2 = new Product("Smartphone", 500, 10);

// корзина и добавление товаров
$cart = new Cart();
try {
    $cart->addItem($product1, 2);
    $cart->addItem($product2, 1);
} catch (ItemOutOfStockException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (CartLimitExceededException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Checkout
$checkout = new Checkout($cart, 2500);
$checkout->setPaymentMethod("credit card");

try {
    $checkout->finalizeOrder();
} catch (InsufficientFundsException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} catch (PaymentGatewayException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
