<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Commande;
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
        $matieres = $this->getDoctrine()->getRepository(Salle::class)->findMatieres();
        $couleurs = $this->getDoctrine()->getRepository(Salle::class)->findCouleurs();
        $tailles = $this->getDoctrine()->getRepository(Salle::class)->findTailles();

        $produits = $produitRepository->findAll();

        return $this->render('index.html.twig', [
            'produits' => $produits,
            'matieres' => $matieres,
            'couleurs' => $couleurs,
            'tailles' => $tailles,
        ]);
    }

    /**
     * @Route("/my_orders", name="commande_membre")
     * @IsGranted("ROLE_USER")
     */
    public function commande_membres()
    {
        $commandesRepository = $this->getDoctrine()->getRepository(Commande::class);
        $commandes = $commandesRepository->findBy([
            'membre' => $this->getUser()->getId()
        ]);

        return $this->render('membre/membre_commande.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("/salle/{id}", name="single_produit_page")
     */
    public function single_product_page(Request $request)
    {
        $commandesRepository = $this->getDoctrine()->getRepository(Commande::class);
        $produitRepository = $this->getDoctrine()->getRepository(Produit::class);
        $produit = $produitRepository->find($request->get('id'));
        $salle = $produit->getSalle();
        $user = $this->getUser();

        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        $form->submit($request->request->get($form->getName()));
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($avis);

            $avis->setDateEnregistrement(new \DateTime('now'));
            $avis->setSalleId($produit->getSalle());
            $avis->setMembreId($user);

            $salle->addAvi($avis);
            $user->addAvi($avis);

            $manager->flush();
            $this->addFlash('success','Votre avis à bien ete créée.');
        }

        $commandes = $commandesRepository->findBy([
            'membre' => $this->getUser()->getId()
        ]);

        return $this->render('produit_page.html.twig', [
            'controller_name' => 'PageController',
            'produit' => $produit,
            'commandes' => $commandes,
            'avisForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/commander/{id}", name="commander_salle")
     */
    public function commander_salle(Request $request)
    {
        $produitRepository = $this->getDoctrine()->getRepository(Produit::class);
        $manager = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $produit = $produitRepository->find($request->get('id'));

        $commande = new Commande();
        $manager->persist($commande);

        $commande->setDateEnregistrement(new \DateTime('now'));
        $commande->setMembre($user);
        $commande->setProduit($produit);
        $produitRepository->removeFromStock($produit);

        $user->addCommande($commande);

        $manager->flush();
        $this->addFlash('success', "La salle à bien été commandée, vous allez recevoir plus d'informations par mail.");

        return $this->redirectToRoute("single_produit_page", [ "id" => $request->get('id') ]);
    }

    /**
     * @Route("/admin", name="admin_office")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin_office()
    {
        $membreCount = $this->getDoctrine()->getRepository(Membre::class)->countMembres();
        $produitCount = $this->getDoctrine()->getRepository(Produit::class)->countProduitsDispo();
        $stockCount = $this->getDoctrine()->getRepository(Produit::class)->countStocks();
        $salleCount = $this->getDoctrine()->getRepository(Salle::class)->countSalles();
        $commandeCount = $this->getDoctrine()->getRepository(Commande::class)->countCommandes();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'PageController',
            'membres' => $membreCount,
            'produits' => $produitCount,
            'salles' => $salleCount,
            'commandes' => $commandeCount,
            'stocks' => $stockCount,
        ]);
    }
}
