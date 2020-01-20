<?php

namespace App\DataFixtures;
use App\Entity\Salle;
use App\Entity\Membre;
use App\Entity\Avis;
use App\Entity\Commande;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
      /*
    for($i=0; $i<=20; $i++){
        $Salle = new Salle;
        $Salle -> setTitre('Salle'.$i);
        $Salle -> setDescription('lorem ipsum');
        $Salle -> setPhoto(rand(1,5).'.jpg');
        $Salle -> setPays(rand(1,5).'Pays');
        $Salle -> setVille(rand(1,5).'Ville');
        $Salle -> setAdresse(rand(1,200).'rue random');
        $Salle -> setCp(rand(1000,9999));
        $Salle -> setCapacite(rand(1,100));
        $Salle -> setCapacite(rand(1,100));
        $Salle -> setCategorie(rand(1,5).'Categorie');
        $Salle -> setPhoto(rand(1,5).".jpg");
        $manager -> persist($Salle);// permet de prendre en compte un objet
        $manager ->flush();// enregistre juste le Salle juste pour prendre l'id du Salle apres


        $Membre = new Membre;
        $Membre -> setpseudo('Pseudo'.$i);
        $Membre -> setmdp('mdp');
        $Membre -> setnom(rand(1,5).'.nom');
        $Membre -> setprenom(rand(1,5).'prenom');
        $Membre -> setemail(rand(1,5).'email');
        $Membre -> setcivilite("Monsieur/Madame");
        $Membre -> setstatut(0);
        $Membre -> setDateEnregistrement(new \DateTime('now'));

  

        $manager -> persist($Membre);// permet de prendre en compte un objet
        $manager ->flush();// enregistre juste le Membre juste pour prendre l'id du Membre apres

        
        $Produit = new Produit;
        $Produit -> setIdSalle($Salle->getId());
        $Produit -> setDateArrivee(new \DateTime('now'));
        $Produit -> setDateDepart(new \DateTime('now + '.rand(1,5).' day'));
        $Produit -> setPrix(rand(200,5000));
        $Produit -> setEtat(rand(1,2).'ETAT');

        $manager -> persist($Produit);// permet de prendre en compte un objet
        $manager ->flush();// enregistre juste le Membre juste pour prendre l'id du Membre apres

        


        for ($j=0; $j<=rand(3,6); $j++) {
            $Avis = new Avis;
            $Avis -> setIdMembre(rand(1, 20));
            $Avis ->setIdSalle($Salle->getId());
            $Avis ->setCommentaire("lorem ipsum");
            $Avis ->setNote(rand(1,5));
            $Avis -> setDateEnregistrement(new \DateTime('now'));
            $manager -> persist($Avis);
            $manager ->flush();
        }
            //php bin console doctrine:fixtures:load
            
    }

    for ($j=0; $j<=rand(3,6); $j++) {
        $Commande = new Commande;
        $Commande -> setIdMembre(rand(1, 20));
        $Commande ->setIdMembre(rand(1, 20));
        $product = new Produit;
        $VerifCommande = rand(1, 20);
        if($product->getId($VerifCommande)->getEtat()=="1ETAT"){
            $Commande ->setIdProduit($VerifCommande);
        }
        $Commande -> setDateEnregistrement(new \DateTime('now'));
        $manager -> persist($Commande);
        $manager ->flush();
    }
          */
    
    }
}
