<?php

namespace App\Event;

use App\Entity\Cart;
use Symfony\Contracts\EventDispatcher\Event;

class PreCartToPurchaseEvent extends Event
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