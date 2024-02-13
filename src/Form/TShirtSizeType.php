<?php

namespace App\Form;

use App\Entity\Enum\TShirtSize;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TShirtSizeType extends AbstractType
{
    public function getParent(): string
    {
        return EnumType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'class' => TShirtSize::class,
                'expanded' => true,
            ])
            ->setAllowedValues('class', TShirtSize::class)
        ;
    }
}
