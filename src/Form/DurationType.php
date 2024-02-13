<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class DurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hour', IntegerType::class, [
                'attr' => ['min' => 0],
            ])
            ->add('minute', IntegerType::class, [
                'attr' => ['min' => 0, 'max' => 59],
            ])
            ->addViewTransformer(new DurationTransformer())
        ;
    }
}
