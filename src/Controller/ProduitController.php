<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index()
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

    /**
     * @Route("/produit/admin/", name="admin_produit")
     */
    public function adminProduit() {
        $repo = $this->getDoctrine()->getRepository(Produit::class);

        $produits = $repo->findAll();
        return $this->render('produit/admin/produit_list.html.twig', [
            'produits' => $produits,
        ]);
    }


    /**
     * @Route("/produit/admin/create", name="admin_produit_create")
     */
    public function createProduit(Request $request) {
        $produit = new Produit();

        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($produit);
            $manager->flush();

            $this->addFlash('success', 'Le produit à été créée avec succès.');

            return $this->redirectToRoute('admin_produit');
        }

        return $this->render('produit/admin/produit_form.html.twig', [
            'produitForm' => $form->createView(),
            'title' => 'Créer un produit'
        ]);
    }

    /**
     * @Route("/produit/admin/delete/{id}", name="admin_produit_delete")
     */
    public function deleteProduit($id) {
        $manager = $this->getDoctrine()->getManager();
        $produit = $manager->find(Produit::class, $id);


        try {
            $manager->remove($produit);
            $manager->flush();
        } catch(Exception $e) {
            $this->addFlash('errors', $e->getMessage());
        }

        $this->addFlash('success', 'La produit ' . $id . ' à été effacé.');
        return $this->redirectToRoute('admin_produit');
    }

    /**
     * @Route("/produit/admin/edit/{id}", name="admin_produit_edit")
     */
    public function editProduit($id, Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $produit = $manager->find(Produit::class, $id);

        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();

            $manager->persist($produit);

            $manager->flush();

            $this->addFlash('success', 'Le produit ' . $id . ' à été edité.');

            return $this->redirectToRoute('admin_produit');
        }

        return $this->render('produit/admin/produit_form.html.twig', [
            'produitForm' => $form->createView(),
            'title' => 'Editer un produit'
        ]);
    }
}
