<?php

namespace App\Form;

use App\Entity\Enum\TShirtSize;
use App\Entity\TShirt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TShirtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('referenceNumber')
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('createdAt')
            ->add('size', EnumType::class, [
                'class' => TShirtSize::class,
                'placeholder' => '--',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TShirt::class,
        ]);
    }
}
