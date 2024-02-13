<?php

namespace App\Form;

use App\Entity\TShirt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TShirtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('createdAt')
            ->add('size', TShirtSizeType::class, [
                'placeholder' => '--',
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
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
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TShirt::class,
        ]);
    }
}
