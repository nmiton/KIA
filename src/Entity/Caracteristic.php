<?php

namespace App\Entity;

use App\Repository\CaracteristicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaracteristicRepository::class)]
class Caracteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $lostByHour;

    #[ORM\OneToMany(mappedBy: 'caracteristic', targetEntity: AnimalCaracteristic::class)]
    private $animalCaracteristics;

    #[ORM\OneToMany(mappedBy: 'caracteritic', targetEntity: ActionCaracteristic::class)]
    private $actionCaracteristics;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->animalCaracteristics = new ArrayCollection();
        $this->actionCaracteristics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLostByHour(): ?int
    {
        return $this->lostByHour;
    }

    public function setLostByHour(int $lostByHour): self
    {
        $this->lostByHour = $lostByHour;

        return $this;
    }

    /**
     * @return Collection<int, AnimalCaracteristic>
     */
    public function getAnimalCaracteristics(): Collection
    {
        return $this->animalCaracteristics;
    }

    public function addAnimalCaracteristic(AnimalCaracteristic $animalCaracteristic): self
    {
        if (!$this->animalCaracteristics->contains($animalCaracteristic)) {
            $this->animalCaracteristics[] = $animalCaracteristic;
            $animalCaracteristic->setCaracteristic($this);
        }

        return $this;
    }

    public function removeAnimalCaracteristic(AnimalCaracteristic $animalCaracteristic): self
    {
        if ($this->animalCaracteristics->removeElement($animalCaracteristic)) {
            // set the owning side to null (unless already changed)
            if ($animalCaracteristic->getCaracteristic() === $this) {
                $animalCaracteristic->setCaracteristic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ActionCaracteristic>
     */
    public function getActionCaracteristics(): Collection
    {
        return $this->actionCaracteristics;
    }

    public function addActionCaracteristic(ActionCaracteristic $actionCaracteristic): self
    {
        if (!$this->actionCaracteristics->contains($actionCaracteristic)) {
            $this->actionCaracteristics[] = $actionCaracteristic;
            $actionCaracteristic->setCaracteritic($this);
        }

        return $this;
    }

    public function removeActionCaracteristic(ActionCaracteristic $actionCaracteristic): self
    {
        if ($this->actionCaracteristics->removeElement($actionCaracteristic)) {
            // set the owning side to null (unless already changed)
            if ($actionCaracteristic->getCaracteritic() === $this) {
                $actionCaracteristic->setCaracteritic(null);
            }
        }

        return $this;
    }

    
}
