<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\ShoppingList;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $repoShoppingList = $this->em->getRepository(ShoppingList::class);
        $requestedDeliveries = $repoShoppingList->findBy(['user' => $this->getUser()]);
        $repoDelivery = $this->em->getRepository(Delivery::class);
        $deliveries = $repoDelivery->findBy(['user' => $this->getUser()]);

        return $this->render('index/index.html.twig', [
            "requestedDeliveries" => $requestedDeliveries,
            "deliveries" => $deliveries,
        ]);
    }
}
