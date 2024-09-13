<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $LibelleEmplacement = null;

    /**
     * @var Collection<int, Borne>
     */
    #[ORM\OneToMany(targetEntity: Borne::class, mappedBy: 'laStation')]
    private Collection $lesBornes;

    #[ORM\ManyToOne(inversedBy: 'lesStations')]
    private ?Maintenance $laMaintenance = null;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'laStation')]
    private Collection $lesVisites;

    public function __construct()
    {
        $this->lesBornes = new ArrayCollection();
        $this->lesVisites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleEmplacement(): ?string
    {
        return $this->LibelleEmplacement;
    }

    public function setLibelleEmplacement(string $LibelleEmplacement): static
    {
        $this->LibelleEmplacement = $LibelleEmplacement;

        return $this;
    }

    /**
     * @return Collection<int, Borne>
     */
    public function getLesBornes(): Collection
    {
        return $this->lesBornes;
    }

    public function addLesBorne(Borne $lesBorne): static
    {
        if (!$this->lesBornes->contains($lesBorne)) {
            $this->lesBornes->add($lesBorne);
            $lesBorne->setLaStation($this);
        }

        return $this;
    }

    public function removeLesBorne(Borne $lesBorne): static
    {
        if ($this->lesBornes->removeElement($lesBorne)) {
            // set the owning side to null (unless already changed)
            if ($lesBorne->getLaStation() === $this) {
                $lesBorne->setLaStation(null);
            }
        }

        return $this;
    }

    public function getLaMaintenance(): ?Maintenance
    {
        return $this->laMaintenance;
    }

    public function setLaMaintenance(?Maintenance $laMaintenance): static
    {
        $this->laMaintenance = $laMaintenance;

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
            $lesVisite->setLaStation($this);
        }

        return $this;
    }

    public function removeLesVisite(Visite $lesVisite): static
    {
        if ($this->lesVisites->removeElement($lesVisite)) {
            // set the owning side to null (unless already changed)
            if ($lesVisite->getLaStation() === $this) {
                $lesVisite->setLaStation(null);
            }
        }

        return $this;
    }
}
