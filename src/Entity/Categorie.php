<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Formation::class, mappedBy="categories")
     */
    private $formations;

    /**
     * Création du constructeur
     */
    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }
    /**
     * 
     * @return int|nullRécupère l'id
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Récupère le nom
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * Redéfinit le nom
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Récupère la formation
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }
    /**
     * 
     * @param Formation $formation
     * @return selfAjoute une formation
     */
    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->addCategory($this);
        }

        return $this;
    }
    /**
     * Supprime une formation
     */
    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeCategory($this);
        }

        return $this;
    }
}
