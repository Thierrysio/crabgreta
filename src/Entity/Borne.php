<?php

namespace App\Entity;

use App\Repository\BorneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BorneRepository::class)]
class Borne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDerniereRevision = null;

    #[ORM\Column]
    private ?int $indiceCompteurUnites = null;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\ManyToMany(targetEntity: Visite::class, mappedBy: 'lesBornes')]
    private Collection $lesVisites;

    #[ORM\ManyToOne(inversedBy: 'lesBornes')]
    private ?TypeBorne $leTypeBorne = null;

    #[ORM\ManyToOne(inversedBy: 'lesBornes')]
    private ?Station $laStation = null;

    public function __construct()
    {
        $this->lesVisites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDerniereRevision(): ?\DateTimeInterface
    {
        return $this->dateDerniereRevision;
    }

    public function setDateDerniereRevision(\DateTimeInterface $dateDerniereRevision): static
    {
        $this->dateDerniereRevision = $dateDerniereRevision;

        return $this;
    }

    public function getIndiceCompteurUnites(): ?int
    {
        return $this->indiceCompteurUnites;
    }

    public function setIndiceCompteurUnites(int $indiceCompteurUnites): static
    {
        $this->indiceCompteurUnites = $indiceCompteurUnites;

        return $this;
    }

    /**
     * @return Collection<int, Visite>
     */
    public function getLesVisites(): Collection
    {
        return $this->lesVisites;
    }

    public function addLesVisite(Visite $lesVisite): static
    {
        if (!$this->lesVisites->contains($lesVisite)) {
            $this->lesVisites->add($lesVisite);
            $lesVisite->addLesBorne($this);
        }

        return $this;
    }

    public function removeLesVisite(Visite $lesVisite): static
    {
        if ($this->lesVisites->removeElement($lesVisite)) {
            $lesVisite->removeLesBorne($this);
        }

        return $this;
    }

    public function getLeTypeBorne(): ?TypeBorne
    {
        return $this->leTypeBorne;
    }

    public function setLeTypeBorne(?TypeBorne $leTypeBorne): static
    {
        $this->leTypeBorne = $leTypeBorne;

        return $this;
    }

    public function getLaStation(): ?Station
    {
        return $this->laStation;
    }

    public function setLaStation(?Station $laStation): static
    {
        $this->laStation = $laStation;

        return $this;
    }
}
