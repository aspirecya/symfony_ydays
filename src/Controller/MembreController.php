<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;
use App\Form\MembreType;
use Symfony\Component\HttpFoundation\Request;
class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index()
    {
        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }

      /**
     * @Route("/membre/admin/", name="admin_membre")
     */
    public function adminMembre() {
        $repo = $this->getDoctrine()->getRepository(Membre::class);

        $Membres = $repo->findAll();
        return $this->render('membre/admin/membre_list.html.twig', [
            'membre' => $Membres,
        ]);
    }

   
}
