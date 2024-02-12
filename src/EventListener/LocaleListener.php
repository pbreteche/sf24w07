<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class LocaleListener
{
    public function __construct(
        private array $acceptedLanguage,
    ) {
    }

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 64)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $locale = $request->getPreferredLanguage($this->acceptedLanguage);

        if ($locale) {
            $request->setLocale($locale);
        }
    }
}
