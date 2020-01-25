<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Membre;
use App\Entity\Produit;
use App\Entity\Salle;
use App\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @Route("/salle/{id}", name="single_produit_page")
     */
    public function single_product_page(Request $request)
    {
        $produitRepository = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $produitRepository->find($request->get('id'));
        $form = $this->createForm(AvisType::class);


        return $this->render('produit_page.html.twig', [
            'controller_name' => 'PageController',
            'produit' => $produit,
            'avisForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin", name="admin_office")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_office()
    {
        $membreCount = $this->getDoctrine()->getRepository(Membre::class)->countMembres();
        $produitCount = $this->getDoctrine()->getRepository(Produit::class)->countProduitsDispo();
        $salleCount = $this->getDoctrine()->getRepository(Salle::class)->countSalles();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'PageController',
            'membres' => $membreCount,
            'produits' => $produitCount,
            'salles' => $salleCount,
        ]);
    }
}
