<?php

namespace App\MessageHandler;

use App\Message\PurchaseMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class PurchaseMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(PurchaseMessage $message)
    {
        $this->logger->info(sprintf('Commande prise en charge pour %s', $message->getPhoneNumber()));
    }
}
