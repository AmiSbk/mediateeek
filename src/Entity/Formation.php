<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * Début de chemin vers les images
     */
    private const CHEMIN_IMAGE = "https://i.ytimg.com/vi/";
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\LessThanOrEqual("now")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $videoId;

    /**
     * @ORM\ManyToOne(targetEntity=Playlist::class, inversedBy="formations")
     */
    private $playlist;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class, inversedBy="formations")
     */
    private $categories;
    /**
     * Création du constructeur
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
    /**
     * Récupère l'id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * Récupère la date de publication
     * @return DateTimeInterface|null
     */
    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * Redéfinit la date de publication
     * @param DateTimeInterface|null $publishedAt
     * @return self
     */
    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
    
    /**
     * Renvoie la date au format ('d/m/Y') ou renvoie une chaîne vide s'il n'y a pas de date
     * @return string
     */
    public function getPublishedAtString(): string {
        if($this->publishedAt == null){
            return "";
        }
        return $this->publishedAt->format('d/m/Y');     
    }      
    
    /**
     * Récupère le titre
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * Redéfinit le titre
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
 
    /**
     * Récupère la description
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Redéfinit la description
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
    
    /** 
     * Récupère la miniature
     */
    public function getMiniature(): ?string
    {
        return self::CHEMIN_IMAGE.$this->videoId."/default.jpg";
    }
    /**
     * Récupère l'image
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return self::CHEMIN_IMAGE.$this->videoId."/hqdefault.jpg";
    }
    
    /**
     * Récupère la video
     */
    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    /**
     * Redéfinit la vidéo
     */
    public function setVideoId(?string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }
    
    /**
     * Récupère la playlist
     * @return Playlist|null
     */
    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    /**
     * Redéfinit la playlist
     */
    public function setPlaylist(?Playlist $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * Récupère les catégories
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }
    
    /**
     * Ajout d'une catégorie
     * @param Categorie $category
     * @return self
     */
    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }
    
    /**
     * suppression d'une catégorie
     * 
     */
    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
