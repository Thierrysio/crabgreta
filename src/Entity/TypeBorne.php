<?php

namespace App\Entity;

use App\Repository\TypeBorneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeBorneRepository::class)]
class TypeBorne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $dureeRevision = null;

    #[ORM\Column]
    private ?int $nbJoursEntreRevisions = null;

    #[ORM\Column]
    private ?int $nbUnitesEntreRevisions = null;

    /**
     * @var Collection<int, Borne>
     */
    #[ORM\OneToMany(targetEntity: Borne::class, mappedBy: 'leTypeBorne')]
    private Collection $lesBornes;

    public function __construct()
    {
        $this->lesBornes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDureeRevision(): ?int
    {
        return $this->dureeRevision;
    }

    public function setDureeRevision(int $dureeRevision): static
    {
        $this->dureeRevision = $dureeRevision;

        return $this;
    }

    public function getNbJoursEntreRevisions(): ?int
    {
        return $this->nbJoursEntreRevisions;
    }

    public function setNbJoursEntreRevisions(int $nbJoursEntreRevisions): static
    {
        $this->nbJoursEntreRevisions = $nbJoursEntreRevisions;

        return $this;
    }

    public function getNbUnitesEntreRevisions(): ?int
    {
        return $this->nbUnitesEntreRevisions;
    }

    public function setNbUnitesEntreRevisions(int $nbUnitesEntreRevisions): static
    {
        $this->nbUnitesEntreRevisions = $nbUnitesEntreRevisions;

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
            $lesBorne->setLeTypeBorne($this);
        }

        return $this;
    }

    public function removeLesBorne(Borne $lesBorne): static
    {
        if ($this->lesBornes->removeElement($lesBorne)) {
            // set the owning side to null (unless already changed)
            if ($lesBorne->getLeTypeBorne() === $this) {
                $lesBorne->setLeTypeBorne(null);
            }
        }

        return $this;
    }

    public function getLesItems(): array
    {
        // Vérifie si la collection de bornes est vide
        if ($this->lesBornes->isEmpty()) {
            return [
                'typeBorne' => $this,
                'bornes' => 'pas de bornes'
            ];
        }
    
        // Si la collection n'est pas vide, elle retourne les bornes
        return [
            'typeBorne' => $this,
            'bornes' => 'bornes to be alive'
        ];
    }
    

}
