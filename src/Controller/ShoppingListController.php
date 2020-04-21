<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ShoppingList;
use App\Form\ShoppingListType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingListController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/shopping/list/{id}", name="shopping_details")
     */
    public function details(int $id)
    {
        $list = $this->em->getRepository(ShoppingList::class)->findOneBy(['id' => $id, 'user' => $this->getUser()]);
        if (empty($list)) return $this->redirectToRoute('index');

        return $this->render('shopping_list/details.html.twig', [
            'shopping_list' => $list
        ]);
    }

    /**
     * @Route("/shopping", name="shopping_list")
     */
    public function index(Request $request)
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        $form = $this->createForm(ShoppingListType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $shoppingList = $form->getData();
            $shoppingList
                ->setUser($this->getUser())
                ->setCreatedAt(new \DateTime('now'));

            $total = 0;
            foreach ($shoppingList->getProducts() as $product)
            {
                $total += $product->getProduct()->getPrice() * $product->getQuantity();
            }
            $shoppingList->setTotalPrice($total);            
            
            $this->em->persist($shoppingList);
            $this->em->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('shopping_list/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/shopping/validate/{id}", name="shopping_validate")
     */
    public function validate(int $id)
    {
        $list = $this->em->getRepository(ShoppingList::class)->findOneBy(['id' => $id]);
        if (empty($list)) return $this->redirectToRoute('index');

        if ($list->getUser() == $this->getUser())
        {
            $list->setHasClientAccepted(true);
            $this->em->persist($list);
            $this->em->flush();

            return $this->redirectToRoute('shopping_details', ['id' => $id]);
        } 
        else if ($list->getDelivery()->getUser() == $this->getUser())
        {
            $list
                ->setDeliveredAt(new \DateTime('now'))
                ->setHasDeliveryAccepted(true);
            $this->em->persist($list);
            $this->em->flush();

            return $this->redirectToRoute('delivery_details', ['id' => $list->getDelivery()->getId()]);
        }
        
        return $this->redirectToRoute('index');
    }
}
