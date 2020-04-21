<?php

namespace App\Controller;

use App\Entity\Product;
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
     * @Route("/shopping", name="shopping_list")
     */
    public function index(Request $request)
    {
        $products = $this->em->getRepository(Product::class)->findAll();

        $form = $this->createForm(ShoppingListType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($form->get('cancel')->isClicked()) return $this->redirectToRoute('index');

            if ($form->isValid())
            {
                dump($form->getData());
                $shoppingList = $form->getData();
                $shoppingList
                    ->setUser($this->getUser())
                    ->setCreatedAt(new \DateTime('now'));
                $this->em->persist($shoppingList);
                $this->em->flush();

                return $this->redirectToRoute('index');
            }
        }

        return $this->render('shopping_list/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }
}
