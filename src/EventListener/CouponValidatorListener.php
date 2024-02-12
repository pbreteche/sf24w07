<?php

namespace App\EventListener;

use App\Event\PreCartToPurchaseEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class CouponValidatorListener
{
    public function __invoke(PreCartToPurchaseEvent $event): void
    {
        $cart = $event->getCart();
        if ($cart) {
            // traitement des coupons sur le panier
        }
    }
}
