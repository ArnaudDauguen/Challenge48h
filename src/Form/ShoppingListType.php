<?php

namespace App\Form;

use App\Entity\ShoppingList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShoppingListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expectedDeliveryStart', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ],
                'required' => true
            ])
            ->add('expectedDeliveryEnd', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepicker'
                ],
                'required' => true
            ])
            ->add('products', CollectionType::class, [
                'entry_type' => ProductsListType::class,
                'allow_add' => true,
                'prototype' => true,
                'required' => true
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ShoppingList::class,
        ]);
    }
}
