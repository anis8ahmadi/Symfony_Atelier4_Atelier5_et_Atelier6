<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $Id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Serie = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $Date_Mise_En_Marche = null;

    #[ORM\Column]
    private ?float $Prix_jour = null;

    /**
     * @var Collection<int, Location>
     */
    #[ORM\OneToMany(targetEntity: Location::class, mappedBy: 'voiture')]
    private Collection $locations;

    #[ORM\ManyToOne(inversedBy: 'Voitures')]
    private ?Modele $modele = null;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function setId(int $Id): static
    {
        $this->Id = $Id;

        return $this;
    }

    public function getSerie(): ?string
    {
        return $this->Serie;
    }

    public function setSerie(?string $Serie): static
    {
        $this->Serie = $Serie;

        return $this;
    }

    public function getDateMiseEnMarche(): ?\DateTime
    {
        return $this->Date_Mise_En_Marche;
    }

    public function setDateMiseEnMarche(\DateTime $Date_Mise_En_Marche): static
    {
        $this->Date_Mise_En_Marche = $Date_Mise_En_Marche;

        return $this;
    }

    public function getPrixJour(): ?float
    {
        return $this->Prix_jour;
    }

    public function setPrixJour(float $Prix_jour): static
    {
        $this->Prix_jour = $Prix_jour;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setVoiture($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getVoiture() === $this) {
                $location->setVoiture(null);
            }
        }

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

}
