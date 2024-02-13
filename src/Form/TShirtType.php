<?php

namespace App\Form;

use App\Entity\TShirt;
use App\EventSubscriber\TShirtTypeSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('color_predefined', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'red' => '#FF0000',
                    'black' => '#000000',
                    'blue' => '#0000FF',
                    'yellow' => '#FFFF00',
                    'green' => '#00FF00',
                ],
                'required' => false,
            ])
            ->add('color', ColorType::class, [
                'required' => false,
            ])
            ->add('duration', DurationType::class, [
                'mapped' => false,
            ])
            ->addEventSubscriber(new TShirtTypeSubscriber())
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'preSubmit'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TShirt::class,
        ]);
    }

    public function preSubmit(FormEvent $event): void
    {
        $data = $event->getData();

        if ($data['color_predefined']) {
            $data['color'] = $data['color_predefined'];
            $event->setData($data);
        }
    }
}
