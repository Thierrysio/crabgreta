<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column]
    private ?int $dureeTotale = null;

    /**
     * @var Collection<int, Borne>
     */
    #[ORM\ManyToMany(targetEntity: Borne::class, inversedBy: 'lesVisites')]
    private Collection $lesBornes;

    #[ORM\ManyToOne(inversedBy: 'lesVisites')]
    private ?Station $laStation = null;

    #[ORM\ManyToOne(inversedBy: 'lesVisites')]
    private ?Maintenance $laMaintenance = null;

    #[ORM\ManyToOne(inversedBy: 'lesVisites')]
    private ?Technicien $leTechnicien = null;

    public function __construct()
    {
        $this->lesBornes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDureeTotale(): ?int
    {
        return $this->dureeTotale;
    }

    public function setDureeTotale(int $dureeTotale): static
    {
        $this->dureeTotale = $dureeTotale;

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
        }

        return $this;
    }

    public function removeLesBorne(Borne $lesBorne): static
    {
        $this->lesBornes->removeElement($lesBorne);

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

    public function getLaMaintenance(): ?Maintenance
    {
        return $this->laMaintenance;
    }

    public function setLaMaintenance(?Maintenance $laMaintenance): static
    {
        $this->laMaintenance = $laMaintenance;

        return $this;
    }

    public function getLeTechnicien(): ?Technicien
    {
        return $this->leTechnicien;
    }

    public function setLeTechnicien(?Technicien $leTechnicien): static
    {
        $this->leTechnicien = $leTechnicien;

        return $this;
    }

    public function getTotalIndiceCompteurUnites(): int
{
    $total = 0;
    foreach ($this->getLesBornes() as $borne) {
        $total += $borne->getIndiceCompteurUnites() ?: 0;
    }
    return $total;
}


}