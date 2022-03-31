<?php

namespace App\Entity;

use App\Repository\ActionObjectsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionObjectsRepository::class)]
class ActionObjects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Action::class, inversedBy: 'actionObjects')]
    #[ORM\JoinColumn(nullable: false)]
    private $action;

    #[ORM\ManyToOne(targetEntity: Objects::class, inversedBy: 'actionObjects')]
    #[ORM\JoinColumn(nullable: false)]
    private $object;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getObject(): ?Objects
    {
        return $this->object;
    }

    public function setObject(?Objects $object): self
    {
        $this->object = $object;

        return $this;
    }
}
