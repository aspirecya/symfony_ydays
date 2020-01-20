<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Salle;
use App\Form\SalleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repo->findAll();
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'SalleController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/salle/admin/", name="admin_salle")
     */
    public function adminSalle() {
        $repo = $this->getDoctrine()->getRepository(Salle::class);

        $salles = $repo->findAll();
        return $this->render('salle/admin/salle_list.html.twig', [
            'salles' => $salles,
        ]);
    }


    /**
     * @Route("/salle/admin/create", name="admin_salle_create")
     */
    public function createSalle(Request $request) {
        $salle = new Salle();

        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $salle->uploadFile();
            $manager->persist($salle);
            $manager->flush();

            $this->addFlash('success', 'La salle à été créée avec succès.');

            return $this->redirectToRoute('admin_salle');
        }

        return $this->render('salle/admin/salle_form.html.twig', [
            'salleForm' => $form->createView(),
            'title' => 'Créer une salle'
        ]);
    }

    /**
     * @Route("/salle/admin/delete/{id}", name="admin_salle_delete")
     */
    public function deleteSalle($id) {
        $manager = $this->getDoctrine()->getManager();
        $salle = $manager->find(Salle::class, $id);


        try {
            $manager->remove($salle);
            $salle->deleteFile();
            $manager->flush();
        } catch(Exception $e) {
            $this->addFlash('errors', $e->getMessage());
        }

        $this->addFlash('success', 'La salle ' . $id . ' à été effacée.');
        return $this->redirectToRoute('admin_salle');
    }

    /**
     * @Route("/salle/admin/edit/{id}", name="admin_salle_edit")
     */
    public function editSalle($id, Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $salle = $manager->find(Salle::class, $id);

        $form = $this->createForm(SalleType::class, $salle);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $salle = $form->getData();

            $manager->persist($salle);

            if($salle->getFile()) {
                $salle->deleteFile();
                $salle->uploadFile();
            }

            $manager->flush();

            $this->addFlash('success', 'La salle ' . $id . ' à été editée.');

            return $this->redirectToRoute('admin_salle');
        }

        return $this->render('salle/admin/salle_form.html.twig', [
            'salleForm' => $form->createView(),
            'title' => 'Editer une salle'
        ]);
    }
}