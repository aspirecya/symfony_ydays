<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Salle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function homepage()
    {
        $produitRepository = $this->getDoctrine()->getRepository(Produit::class);
        $categories = $this->getDoctrine()->getRepository(Salle::class)->findCategories();

        $produits = $produitRepository->findAll();

        return $this->render('index.html.twig', [
            'controller_name' => 'PageController',
            'produits' => $produits,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin", name="admin_office")
     */
    public function admin_office()
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
