<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\Purchase;
use App\Event\PostCartToPurchaseEvent;
use App\Event\PreCartToPurchaseEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

readonly class CartValidator
{
    public function __construct(
        private LoggerInterface $logger,
        private EventDispatcher $dispatcher,
    ) {

    }

    public function createPurchase(Cart $cart): Purchase
    {
        $this->dispatcher->dispatch(new PreCartToPurchaseEvent($cart));

        $this->logger->info('cart to purchase from cart: '.$cart->getId());
        $purchase = new Purchase();

        $this->dispatcher->dispatch(new PostCartToPurchaseEvent($purchase));

        return  $purchase;
    }
}
