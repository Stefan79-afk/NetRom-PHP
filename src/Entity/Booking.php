<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'integer')]
    private $duration;

    #[ORM\OneToOne(targetEntity: Car::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $carId;

    #[ORM\OneToOne(targetEntity: Plugs::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $plugId;

    #[ORM\Column(type: 'datetime')]
    private $startTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCarId(): ?Car
    {
        return $this->carId;
    }

    public function setCarId(Car $carId): self
    {
        $this->carId = $carId;

        return $this;
    }

    public function getPlugId(): ?Plugs
    {
        return $this->plugId;
    }

    public function setPlugId(Plugs $plugId): self
    {
        $this->plugId = $plugId;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }
}
