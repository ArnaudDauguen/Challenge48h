<?php

namespace App\Form;

use App\Entity\Delivery;
use App\Entity\ShoppingList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class DeliveryType extends AbstractType
{
    public function __construct(EntityManagerInterface $em, Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ShoppingLists', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => $this->em->getRepository(ShoppingList::class)->findSuitableShoppingLists($this->security->getUser()),
                'choice_label' => function($choice, $key, $value) {
                    return ' ';
                }
            ])
            ->add('confirmer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
        ]);
    }
}
