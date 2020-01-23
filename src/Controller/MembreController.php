<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;
use App\Form\MembreType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @Route("/admin/membre/", name="admin_membre")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminMembre() {
        $repo = $this->getDoctrine()->getRepository(Membre::class);

        $Membres = $repo->findAll();
        return $this->render('admin/membre_list.html.twig', [
            'membre' => $Membres,
        ]);
    }

   
}
