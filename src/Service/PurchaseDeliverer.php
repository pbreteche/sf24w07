<?php

namespace App\Service;

use App\Entity\Purchase;
use App\Message\PurchaseMessage;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class PurchaseDeliverer
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {
    }

    public function deliver(Purchase $purchase): void
    {
        $this->bus->dispatch(new PurchaseMessage($purchase));
    }
}
