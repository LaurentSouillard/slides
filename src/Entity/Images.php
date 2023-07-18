<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descriptif = null;

    #[ORM\Column]
    private ?bool $in_slide = false;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Galleries $gallery = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Categories $categorie = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function isInSlide(): ?bool
    {
        return $this->in_slide;
    }

    public function setInSlide(bool $in_slide): self
    {
        $this->in_slide = $in_slide;

        return $this;
    }

    public function getGallery(): ?Galleries
    {
        return $this->gallery;
    }

    public function setGallery(?Galleries $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
