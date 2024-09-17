<?php

namespace App\Entity;

use App\Repository\MaintenanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Station>
     */
    #[ORM\OneToMany(targetEntity: Station::class, mappedBy: 'laMaintenance')]
    private Collection $lesStations;

    /**
     * @var Collection<int, Visite>
     */
    #[ORM\OneToMany(targetEntity: Visite::class, mappedBy: 'laMaintenance')]
    private Collection $lesVisites;

    /**
     * @var Collection<int, Technicien>
     */
    #[ORM\OneToMany(targetEntity: Technicien::class, mappedBy: 'laMaintenance')]
    private Collection $lesTechniciens;

    public function __construct()
    {
        $this->lesStations = new ArrayCollection();
        $this->lesVisites = new ArrayCollection();
        $this->lesTechniciens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Station>
     */
    public function getLesStations(): Collection
    {
        return $this->lesStations;
    }

    public function addLesStation(Station $lesStation): static
    {
        if (!$this->lesStations->contains($lesStation)) {
            $this->lesStations->add($lesStation);
            $lesStation->setLaMaintenance($this);
        }

        return $this;
    }

    public function removeLesStation(Station $lesStation): static
    {
        if ($this->lesStations->removeElement($lesStation)) {
            // set the owning side to null (unless already changed)
            if ($lesStation->getLaMaintenance() === $this) {
                $lesStation->setLaMaintenance(null);
            }
        }

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
            $lesVisite->setLaMaintenance($this);
        }

        return $this;
    }

    public function removeLesVisite(Visite $lesVisite): static
    {
        if ($this->lesVisites->removeElement($lesVisite)) {
            // set the owning side to null (unless already changed)
            if ($lesVisite->getLaMaintenance() === $this) {
                $lesVisite->setLaMaintenance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Technicien>
     */
    public function getLesTechniciens(): Collection
    {
        return $this->lesTechniciens;
    }

    public function addLesTechnicien(Technicien $lesTechnicien): static
    {
        if (!$this->lesTechniciens->contains($lesTechnicien)) {
            $this->lesTechniciens->add($lesTechnicien);
            $lesTechnicien->setLaMaintenance($this);
        }

        return $this;
    }

    public function removeLesTechnicien(Technicien $lesTechnicien): static
    {
        if ($this->lesTechniciens->removeElement($lesTechnicien)) {
            // set the owning side to null (unless already changed)
            if ($lesTechnicien->getLaMaintenance() === $this) {
                $lesTechnicien->setLaMaintenance(null);
            }
        }

        return $this;
    }

    public function getDureeTotaleDesVisites(): int
{
    $dureeTotale = 0;

    foreach ($this->getLesVisites() as $visite) {
        $dureeTotale += $visite->getDureeTotale() ?: 0;
    }

    return $dureeTotale;
}
public function getTotalIndiceCompteurUnites(): int
{
    $total = 0;

    // Parcourt chaque visite associée à cette maintenance
    foreach ($this->getLesVisites() as $visite) {
        // Pour chaque visite, parcourt les bornes associées
        foreach ($visite->getLesBornes() as $borne) {
            // Ajoute l'indiceCompteurUnites de chaque borne au total
            $total += $borne->getIndiceCompteurUnites() ?: 0;
        }
    }

    return $total;
}

public function getTotalIndiceCompteurUnites2(): int
{
    $total = 0;

    // Parcourt chaque visite associée à cette maintenance
    foreach ($this->getLesVisites() as $visite) {
        // Ajoute le total des indiceCompteurUnites pour chaque visite
        $total += $visite->getTotalIndiceCompteurUnites();
    }

    return $total;
}

public function getNombreBornesParTypeBorne(): array
{
    $bornesParType = [];

    // Parcourt chaque visite de cette maintenance
    foreach ($this->getLesVisites() as $visite) {
        // Récupère le nombre de bornes par type de borne pour chaque visite
        $bornesVisiteParType = $visite->getNombreBornesParTypeBorne();

        // Ajoute les résultats au total pour chaque type de borne
        foreach ($bornesVisiteParType as $typeBorneId => $nombreBornes) {
            if (!isset($bornesParType[$typeBorneId])) {
                $bornesParType[$typeBorneId] = 0;
            }
            $bornesParType[$typeBorneId] += $nombreBornes;
        }
    }

    return $bornesParType;
}


}
