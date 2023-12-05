<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueRepository::class)]
class Marque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: Model::class)]
    private Collection $marque;

    public function __construct()
    {
        $this->marque = new ArrayCollection();
    }

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    #[ORM\PostRemove]
    public function deleteImage()
    {
        if ($this->logo != null) {
            unlink(__DIR__ . '/../../public/uploads/' . $this->logo);
        }
        return true;
    }

    /**
     * @return Collection<int, Model>
     */
    public function getMarque(): Collection
    {
        return $this->marque;
    }

    public function addMarque(Model $marque): static
    {
        if (!$this->marque->contains($marque)) {
            $this->marque->add($marque);
            $marque->setMarque($this);
        }

        return $this;
    }

    public function removeMarque(Model $marque): static
    {
        if ($this->marque->removeElement($marque)) {
            // set the owning side to null (unless already changed)
            if ($marque->getMarque() === $this) {
                $marque->setMarque(null);
            }
        }

        return $this;
    }
}
