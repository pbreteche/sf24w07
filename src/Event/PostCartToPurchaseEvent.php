<?php

namespace App\Event;

use App\Entity\Cart;
use App\Entity\Purchase;

class PostCartToPurchaseEvent
{
     public function __construct(
         private Purchase $purchase,
     ) {
     }

    public function getPurchase(): Cart
    {
        return $this->purchase;
    }
}