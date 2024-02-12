<?php

namespace App\Event;

use App\Entity\Cart;

class PreCartToPurchaseEvent
{
     public function __construct(
         private Cart $cart,
     ) {
     }

    public function getCart(): Cart
    {
        return $this->cart;
    }
}