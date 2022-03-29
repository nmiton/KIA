<?php

namespace App\Entity;

use App\Repository\AnimalCaracteristicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalCaracteristicRepository::class)]
class AnimalCaracteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'animalCaracteristics')]
    #[ORM\JoinColumn(nullable: false)]
    private $animal;

    #[ORM\ManyToOne(targetEntity: Caracteristic::class, inversedBy: 'animalCaracteristics')]
    #[ORM\JoinColumn(nullable: false)]
    private $caracteristic;

    #[ORM\Column(type: 'integer')]
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): self
    {
        $this->animal = $animal;

        return $this;
    }

    public function getCaracteristic(): ?Caracteristic
    {
        return $this->caracteristic;
    }

    public function setCaracteristic(?Caracteristic $caracteristic): self
    {
        $this->caracteristic = $caracteristic;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
