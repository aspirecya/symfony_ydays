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

        $Membres = $repo->findAll();
        return $this->render('admin/membre_list.html.twig', [
            'membre' => $Membres,
        ]);
    }



    /**
     * @Route("membre/edit", name="Membre_edit")
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




/*
    private function editUserPassword(User $user, $newPassword, $em)
    {
        $encoder = $this->container->get('security.encoder_factory');
        $newPasswordEncoded = $encoder->encodePassword($user, $newPassword);
        $user->setPassword($newPasswordEncoded);
        $em->persist($user);
        $em->flush();
         
        $session->getFlashBag()->set('success', "Password changed successfully!");
    }


    public function editPasswordAction(Request $request)
{
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
        throw $this->createAccessDeniedException();
    }
     
    // ici tu construits ton formulaire de changement de mot de passe
    // (donc il faut le créer)
    $changePasswordModel = new ChangePassword();
    $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);
 
    $form->handleRequest($request);
 
    if ($form->isSubmitted() && $form->isValid()) {
        // à ce moment, on sait que on a soumis le formulaire, et qu'il est valide
        // Il faut donc récupérer les paramètre de notre requète, et executer la fonction
         
        $newPassword = $request->get('new_password');
        $em = $this->getDoctrine()->getManager();
        // get the user you want, from your form, params, or whatever
        $user = $this->getUser();
         
        $this->editUserPassword($user, $newPassword, $em);
         
        return $this->redirect($this->generateUrl('change_passwd_success'));
    }
 
    return $this->render('AppUserBundle:Admin:changePassword.html.twig', array(
        'form' => $form->createView(),
    ));     
}
*/
}
