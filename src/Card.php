<?php

namespace OnlineStore;

use OnlineStore\Exceptions\ItemOutOfStockException;
use OnlineStore\Exceptions\CartLimitExceededException;

class Cart {
    private $items = [];
    private $maxItems = 20;

    public function addItem(Product $product, $quantity) {
        if (count($this->items) >= $this->maxItems) {
            throw new CartLimitExceededException("Превышен лимит корзины");
        }
        if (!isset($this->items[$product->getName()])) {
            $this->items[$product->getName()] = ['product' => $product, 'quantity' => 0];
        }
        if ($this->items[$product->getName()]['product']->getStock() < $quantity) {
            throw new ItemOutOfStockException("Товара нет в наличии");
        }
        $this->items[$product->getName()]['quantity'] += $quantity;
        $this->items[$product->getName()]['product']->reduceStock($quantity);
    }

    public function removeItem(Product $product) {
        unset($this->items[$product->getName()]);
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        return $total;
    }
}
