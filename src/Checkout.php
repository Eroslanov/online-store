<?php

namespace OnlineStore;

use OnlineStore\Exceptions\PaymentGatewayException;
use OnlineStore\Exceptions\InsufficientFundsException;

class Checkout
{
    private Cart $cart;
    private $paymentMethod;
    private float $userBalance;

    public function __construct(Cart $cart, float $userBalance)
    {
        $this->cart = $cart;
        $this->userBalance = $userBalance;
    }

    public function setPaymentMethod($method)
    {
        $this->paymentMethod = $method;
    }

    public function processPayment(float $amount)
    {
        if ($this->userBalance < $amount) {
            throw new InsufficientFundsException("Недостаточно средств");
        }

        if (rand(0, 1)) {
            throw new PaymentGatewayException("Ошибка платежа");
        }
        $this->userBalance -= $amount;
    }

    public function finalizeOrder()
    {
        try {
            $total = $this->cart->getTotal();
            $this->processPayment($total);
            echo "Заказ успешно выполнен\n";
        } catch (InsufficientFundsException $e) {
            echo "ошибка: " . $e->getMessage() . "\n";
        } catch (PaymentGatewayException $e) {
            echo "ошибка: " . $e->getMessage() . "\n";
        }
    }
}
