<?php

use PHPUnit\Framework\TestCase;
use OnlineStore\Product;
use OnlineStore\Cart;
use OnlineStore\Checkout;
use OnlineStore\Exceptions\InsufficientFundsException;
use OnlineStore\Exceptions\PaymentGatewayException;

class CheckoutTest extends TestCase
{
    public function testFinalizeOrderSuccess(): void
    {
        $product1 = new Product("Laptop", 1000, 5);
        $product2 = new Product("Smartphone", 500, 10);
        $cart = new Cart();
        $cart->addItem($product1, 2);
        $cart->addItem($product2, 1);
        $checkout = new Checkout($cart, 2500);
        $checkout->setPaymentMethod("credit card");
        $this->expectOutputString("Заказ успешно выполнен\n");
        $checkout->finalizeOrder();
    }

    public function testFinalizeOrderInsufficientFunds(): void
    {
        $product1 = new Product("Laptop", 1000, 5);
        $product2 = new Product("Smartphone", 500, 10);
        $cart = new Cart();
        $cart->addItem($product1, 2);
        $cart->addItem($product2, 1);
        $checkout = new Checkout($cart, 2000);
        $checkout->setPaymentMethod("credit card");
        $this->expectOutputString("ошибка: Недостаточно средств\n");
        $checkout->finalizeOrder();
    }

    public function testFinalizeOrderPaymentGatewayError(): void
    {
        $product1 = new Product("Laptop", 1000, 5);
        $product2 = new Product("Smartphone", 500, 10);
        $cart = new Cart();
        $cart->addItem($product1, 2);
        $cart->addItem($product2, 1);
        $checkout = new Checkout($cart, 3000);
        $checkout->setPaymentMethod("credit card");
        $this->expectOutputString("ошибка: Ошибка платежа\n");
        $checkout->finalizeOrder();
    }
}
