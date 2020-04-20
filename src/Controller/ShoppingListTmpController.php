<?php

namespace App\Controller;

use App\Entity\ShoppingList;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ShoppingListTmpController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/shoppingList/{id}", name="shopping_list_display")
     */
    public function tmpShoppingListDisplay(int $id)
    {
        $repoShoppingList = $this->em->getRepository(ShoppingList::class);
        $shoppingList = $repoShoppingList->findOneBy(['id' => $id]);

        dump($shoppingList);

        //TODO use correct template
        return $this->render('index/index.html.twig', [
            "requestedDeliveries" => [$shoppingList],
        ]);
    }

    /**
     * @Route("/deliveryList/{id}", name="delivery_list_display")
     */
    public function tmpDeliveryListDisplay(int $id)
    {
        $repoShoppingList = $this->em->getRepository(ShoppingList::class);
        $shoppingList = $repoShoppingList->findOneBy(['id' => $id]);

        dump($shoppingList);

        //TODO use correct template
        return $this->render('index/index.html.twig', [
            "requestedDeliveries" => [$shoppingList],
        ]);
    }
}
