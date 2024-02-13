<?php

namespace App\EventSubscriber;

use App\Entity\TShirt;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TShirtTypeSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SET_DATA => 'preSetData',
        ];
    }

    public function preSetData(FormEvent $event): void
    {
        $tShirt = $event->getData();
        if (!$tShirt instanceof TShirt) {
            throw new \InvalidArgumentException();
        }

        if (!$tShirt->getId()) {
            $event
                ->getForm()
                ->add('referenceNumber', options: [
                    'priority' => 100, // put this field before lower priorities
                ])
            ;
        }
    }
}