<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class CommandeController extends AbstractController
{
    /**
     * @Route("/admin/commande/", name="admin_commande")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminCommande() {
        $repo = $this->getDoctrine()->getRepository(Commande::class);

        $commandes = $repo->findAll();
        return $this->render('admin/commande_list.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/admin/commande/create", name="admin_commande_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function createCommande(Request $request) {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($commande);
            $commande->setDateEnregistrement(new \DateTime('now'));
            $manager->flush();

            $this->addFlash('success', 'La commande à été créée avec succès.');

            return $this->redirectToRoute('admin_commande');
        }

        return $this->render('admin/forms/commande_form.html.twig', [
            'commandeForm' => $form->createView(),
            'title' => 'Créer une commande'
        ]);
    }

    /**
     * @Route("/admin/commande/delete/{id}", name="admin_commande_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteCommande($id) {
        $manager = $this->getDoctrine()->getManager();
        $commande = $manager->find(Commande::class, $id);


        try {
            $manager->remove($commande);
            $manager->flush();
        } catch(Exception $e) {
            $this->addFlash('errors', $e->getMessage());
        }

        $this->addFlash('success', 'La commande ' . $id . ' à été effacé.');
        return $this->redirectToRoute('admin_commande');
    }

    /**
     * @Route("/admin/commande/edit/{id}", name="admin_commande_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editCommande($id, Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $commande = $manager->find(Commande::class, $id);

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $commande = $form->getData();

            $manager->persist($commande);

            $manager->flush();

            $this->addFlash('success', 'La commande ' . $id . ' à été edité.');

            return $this->redirectToRoute('admin_commande');
        }

        return $this->render('admin/forms/commande_form.html.twig', [
            'commandeForm' => $form->createView(),
            'title' => 'Editer une commande'
        ]);
    }
}
