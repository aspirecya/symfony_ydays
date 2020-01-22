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
     * @Route("/admin/membre/", name="admin_membre")
     */
    public function adminMembre() {
        $repo = $this->getDoctrine()->getRepository(Membre::class);

        $Membres = $repo->findAll();
        return $this->render('admin/membre_list.html.twig', [
            'membre' => $Membres,
        ]);
    }

    /**
     * @Route("/membre/create", name="membre_create")
     */
    public function MembreCreate(Request $request){


        $Membre = new Membre;
      
                $form =$this ->createForm(MembreType::class,$Membre);
                $form ->handleRequest($request);
    
                if($form ->isSubmitted() && $form ->isValid()){
                    $manager = $this ->getDoctrine() ->getManager();
                    $manager ->persist($Membre);
                    $manager -> flush();
                    $this ->addFLash('sucess','Votre compte a bien ete creer');
                    $this->redirectToRoute('home');
                }
                return $this -> render('membre/membre_form.html.twig',array('userForm' =>$form ->createView()));
            
    }
}
