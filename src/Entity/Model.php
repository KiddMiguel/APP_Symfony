<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModelRepository::class)]
class Model
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix_depart = null;

    #[ORM\ManyToOne(targetEntity: Marque::class, inversedBy: 'models')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Marque $marque = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixDepart(): ?float
    {
        return $this->prix_depart;
    }

    public function setPrixDepart(?float $prix_depart): static
    {
        $this->prix_depart = $prix_depart;

        return $this;
    }
    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

}
