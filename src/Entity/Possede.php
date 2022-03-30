<?php

namespace App\Entity;

use App\Repository\PossedeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PossedeRepository::class)]
class Possede
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'possedes')]
    #[ORM\JoinColumn(nullable: false)]
    private $idUser;

    #[ORM\ManyToOne(targetEntity: Objet::class, inversedBy: 'possedes')]
    #[ORM\JoinColumn(nullable: false)]
    private $idObjet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdObjet(): ?Objet
    {
        return $this->idObjet;
    }

    public function setIdObjet(?Objet $idObjet): self
    {
        $this->idObjet = $idObjet;

        return $this;
    }
}
