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
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $location;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Plugs::class, orphanRemoval: true)]
    private $plugs;

    public function __construct()
    {
        $this->plugs = new ArrayCollection();
    }


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

    /**
     * @return Collection<int, Plugs>
     */
    public function getPlugs(): Collection
    {
        return $this->plugs;
    }

    public function addPlug(Plugs $plug): self
    {
        if (!$this->plugs->contains($plug)) {
            $this->plugs[] = $plug;
            $plug->setStation($this);
        }

        return $this;
    }

    public function removePlug(Plugs $plug): self
    {
        if ($this->plugs->removeElement($plug)) {
            // set the owning side to null (unless already changed)
            if ($plug->getStation() === $this) {
                $plug->setStation(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }

}
