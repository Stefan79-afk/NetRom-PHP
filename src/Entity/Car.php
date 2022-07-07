<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $plate;

    #[ORM\Column(type: 'string', length: 255)]
    private $plugType;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'cars')]
    private $userId;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlate(): ?string
    {
        return $this->plate;
    }

    public function setPlate(string $plate): self
    {
        $this->plate = $plate;

        return $this;
    }

    public function getPlugType(): ?string
    {
        return $this->plugType;
    }

    public function setPlugType(string $plugType): self
    {
        $this->plugType = $plugType;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->userId->contains($userId)) {
            $this->userId[] = $userId;
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        $this->userId->removeElement($userId);

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }

    public function getUsersArr(): array{
        $user = $this->getUserId();
        return $user->getValues();
    }
}
