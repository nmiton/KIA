<?php

namespace App\Entity;

use App\Repository\PossedeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PossedeRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'inventaries')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Objects::class, inversedBy: 'inventaries')]
    #[ORM\JoinColumn(nullable: false)]
    private $objet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getObjet(): ?Objects
    {
        return $this->objet;
    }

    public function setObjet(?Objects $objet): self
    {
        $this->objet = $objet;

        return $this;
    }
}
