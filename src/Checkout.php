<?php

namespace OnlineStore;

use OnlineStore\Exceptions\PaymentGatewayException;
use OnlineStore\Exceptions\InsufficientFundsException;

class Checkout {
    private $cart;
    private $paymentMethod;
    private $userBalance;

    public function __construct(Cart $cart, $userBalance) {
        $this->cart = $cart;
        $this->userBalance = $userBalance;
    }

    public function setPaymentMethod($method) {
        $this->paymentMethod = $method;
    }

    public function processPayment($amount) {
        if ($this->userBalance < $amount) {
            throw new InsufficientFundsException("Insufficient funds");
        }
        // Simulate payment gateway processing
        if (rand(0, 1)) { // Randomly simulate success or failure
            throw new PaymentGatewayException("Payment gateway error");
        }
        $this->userBalance -= $amount;
    }

    public function finalizeOrder() {
        try {
            $total = $this->cart->getTotal();
            $this->processPayment($total);
            echo "Order finalized successfully!\n";
        } catch (InsufficientFundsException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        } catch (PaymentGatewayException $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}