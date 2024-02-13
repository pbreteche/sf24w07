<?php

namespace App\Form;

use App\Entity\TShirt;
use App\EventSubscriber\TShirtTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->addEventSubscriber(new TShirtTypeSubscriber())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TShirt::class,
        ]);
    }
}
