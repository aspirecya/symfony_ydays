<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;
use App\Form\MembreType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

        $membres = $repo->findAll();
        return $this->render('admin/membre_list.html.twig', [
            'membres' => $membres,
        ]);
    }



    /**
     * @Route("membre/edit", name="membre_edit")
     */
    public function editMembre(UserPasswordEncoderInterface $passwordEncoder,Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $Membre = $manager->find(Membre::class,$userId);

        $form = $this->createForm(MembreType::class, $Membre);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $Membre = $form->getData();
           if (!empty($form->get('plainPassword')->getData())) {
               $password= $passwordEncoder->encodePassword(
                  $Membre,
                  $form->get('plainPassword')->getData()
              );

               if ($password != $Membre->getPassword()) {
                   $Membre->setPassword(
                   $passwordEncoder->encodePassword(
                    $Membre,
                    $form->get('plainPassword')->getData()
                )
               );
               }
           }
            $manager->persist($Membre);

         
            $manager->flush();

            $this->addFlash('success', 'La Membre à été editée.');

            return $this->redirectToRoute('index');
        }

        return $this->render('membre/membre_form.html.twig', [
            'MembreForm' => $form->createView(),
            'title' => 'Editer une Membre'
        ]);
    }
}
