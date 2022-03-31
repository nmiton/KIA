<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'text')]
    private $consoleLog;

    #[ORM\ManyToOne(targetEntity: AnimalType::class, inversedBy: 'actions')]
    #[ORM\JoinColumn(nullable: false)]
    private $animalType;

    #[ORM\OneToMany(mappedBy: 'action', targetEntity: ActionCaracteristic::class)]
    private $actionCaracteristics;

    #[ORM\OneToMany(mappedBy: 'action', targetEntity: ActionObjects::class)]
    private $actionObjects;

    public function __construct()
    {
        $this->actionCaracteristics = new ArrayCollection();
        $this->actionObjects = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getConsoleLog(): ?string
    {
        return $this->consoleLog;
    }

    public function setConsoleLog(string $consoleLog): self
    {
        $this->consoleLog = $consoleLog;

        return $this;
    }

    public function getAnimalType(): ?AnimalType
    {
        return $this->animalType;
    }

    public function setAnimalType(?AnimalType $animalType): self
    {
        $this->animalType = $animalType;

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
            $actionCaracteristic->setAction($this);
        }

        return $this;
    }

    public function removeActionCaracteristic(ActionCaracteristic $actionCaracteristic): self
    {
        if ($this->actionCaracteristics->removeElement($actionCaracteristic)) {
            // set the owning side to null (unless already changed)
            if ($actionCaracteristic->getAction() === $this) {
                $actionCaracteristic->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ActionObjects>
     */
    public function getActionObjects(): Collection
    {
        return $this->actionObjects;
    }

    public function addActionObject(ActionObjects $actionObject): self
    {
        if (!$this->actionObjects->contains($actionObject)) {
            $this->actionObjects[] = $actionObject;
            $actionObject->setAction($this);
        }

        return $this;
    }

    public function removeActionObject(ActionObjects $actionObject): self
    {
        if ($this->actionObjects->removeElement($actionObject)) {
            // set the owning side to null (unless already changed)
            if ($actionObject->getAction() === $this) {
                $actionObject->setAction(null);
            }
        }

        return $this;
    }
}
