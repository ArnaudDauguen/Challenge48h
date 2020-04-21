<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\ShoppingList;
use App\Form\DeliveryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/delivery/find", name="delivery_finder")
     */
    public function index(Request $request)
    {
        $shoppingLists = $this->em->getRepository(ShoppingList::class)->findAll();
        $filteredShoppingLists = [];
        foreach($shoppingLists as $shoppingList){
            if(!empty($shoppingList->getDeliveredAt()))
                array_push($filteredShoppingLists, $shoppingList);
        }
        dump($filteredShoppingLists);
        if (sizeof($filteredShoppingLists) <= 0) return $this->redirectToRoute('index');

        $form = $this->createForm(DeliveryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $delivery = $form->getData();
            $delivery->setUser($this->getUser());
            $this->em->persist($delivery);
            $this->em->flush();

            return $this->redirectToRoute('delivery_details', ['id' => $delivery->getId()]);
        }

        return $this->render('delivery/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delivery/details/{id}", name="delivery_details")
     */
    public function details(int $id)
    {
        $delivery = $this->em->getRepository(Delivery::class)->findOneBy(['id' => $id, 'user' => $this->getUser()]);
        if (empty($delivery)) return $this->redirectToRoute('index');

        return $this->render('delivery/details.html.twig', [
            'delivery' => $delivery
        ]);
    }
}
