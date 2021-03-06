<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalleRepository")
 */
class Salle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $photo;
    private $file;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $matiere;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $taille;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $couleur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="salle", fetch="EAGER", cascade={"remove"})
     */
    private $produits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="salle", fetch="EAGER", cascade={"remove"})
     */
    private $avis;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = NULL): self
    {
        $this->file = $file;
        return $this;
    }

    public function uploadFile()
    {
        $name = $this->file->getClientOriginalName();
        $new_name = 'photo_' . time() . '_' . rand(1, 9999) . '_' . $name;
        $dirPhoto = __DIR__ . '/../../public/images/salles';
        $this->file->move($dirPhoto, $new_name);
        $this->photo = $new_name;
    }

    public function deleteFile()
    {
        if(file_exists(__DIR__ . '/../../public/images/salles' . $this->photo)) {
            unlink(__DIR__ . '/../../public/images/salles' . $this->photo);
        }
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setSalle($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
            // set the owning side to null (unless already changed)
            if ($produit->getSalle() === $this) {
                $produit->setSalle(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre . " (ID: " . $this->id . ")";
    }

    /**
     * @return Collection|Avis[]
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis[] = $avi;
            $avi->setSalleId($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->contains($avi)) {
            $this->avis->removeElement($avi);
            // set the owning side to null (unless already changed)
            if ($avi->getSalleId() === $this) {
                $avi->setSalleId(null);
            }
        }

        return $this;
    }
}
