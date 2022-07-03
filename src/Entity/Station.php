<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $location;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToOne(mappedBy: 'stationId', targetEntity: Plugs::class, cascade: ['persist', 'remove'])]
    private $plugs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPlugs(): ?Plugs
    {
        return $this->plugs;
    }

    public function setPlugs(Plugs $plugs): self
    {
        // set the owning side of the relation if necessary
        if ($plugs->getStationId() !== $this) {
            $plugs->setStationId($this);
        }

        $this->plugs = $plugs;

        return $this;
    }
}
