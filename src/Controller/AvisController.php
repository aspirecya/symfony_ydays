<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="avis")
     */
    public function index()
    {
        return $this->render('avis/index.html.twig', [
            'controller_name' => 'AvisController',
        ]);
    }

    /**
     * @Route("/avis/create", name="avis_create")
     */
    public function avisCreate(Request $request)
    {


        $avis = new Avis;

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($avis);
            $manager->flush();
            $this->addFlash('success','Votre avis à bien ete créée.');
            $this->redirectToRoute('home');
        }
        return $this->render('avis/avis_form.html.twig', [
            'avisForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/avis/", name="admin_avis")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminAvis()
    {
        $repo = $this->getDoctrine()->getRepository(Avis::class);

        $Avis = $repo->findAll();
        return $this->render('admin/avis_list.html.twig', [
            'avis' => $Avis,
        ]);
    }



    /**
     * @Route("/admin/avis/delete/{id}", name="admin_avis_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteAvis($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $Avis = $manager->find(Avis::class, $id);


        try {
            $manager->remove($Avis);
            $Avis->deleteFile();
            $manager->flush();
        } catch (Exception $e) {
            $this->addFlash('errors', $e->getMessage());
        }

        $this->addFlash('success', 'L avis ' . $id . ' à été effacée.');
        return $this->redirectToRoute('admin_avis');
    }
}
