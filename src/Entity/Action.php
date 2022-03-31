<?php

namespace App\Entity;

use App\Repository\ActionRepository;
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
}
