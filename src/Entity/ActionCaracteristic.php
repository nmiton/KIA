<?php

namespace App\Entity;

use App\Repository\ActionCaracteristicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionCaracteristicRepository::class)]
class ActionCaracteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $valMax;

    #[ORM\Column(type: 'integer')]
    private $valMin;

    #[ORM\ManyToOne(targetEntity: Action::class, inversedBy: 'actionCaracteristics')]
    #[ORM\JoinColumn(nullable: false)]
    private $action;

    #[ORM\ManyToOne(targetEntity: Caracteristic::class, inversedBy: 'actionCaracteristics')]
    #[ORM\JoinColumn(nullable: false)]
    private $caracteritic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValMax(): ?int
    {
        return $this->valMax;
    }

    public function setValMax(int $valMax): self
    {
        $this->valMax = $valMax;

        return $this;
    }

    public function getValMin(): ?int
    {
        return $this->valMin;
    }

    public function setValMin(int $valMin): self
    {
        $this->valMin = $valMin;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getCaracteritic(): ?Caracteristic
    {
        return $this->caracteritic;
    }

    public function setCaracteritic(?Caracteristic $caracteritic): self
    {
        $this->caracteritic = $caracteritic;

        return $this;
    }
}
