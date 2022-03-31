<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjetRepository::class)]
class Objects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $lossPercentage;

    #[ORM\OneToMany(mappedBy: 'objet', targetEntity: Inventory::class)]
    private $inventories;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'object', targetEntity: ActionObjects::class)]
    private $actionObjects;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getLossPercentage(): ?int
    {
        return $this->lossPercentage;
    }

    public function setLossPercentage(int $lossPercentage): self
    {
        $this->lossPercentage = $lossPercentage;

        return $this;
    }

    /**
     * @return Collection<int, Possede>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setObjet($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getObjet() === $this) {
                $inventory->setObjet(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $actionObject->setObject($this);
        }

        return $this;
    }

    public function removeActionObject(ActionObjects $actionObject): self
    {
        if ($this->actionObjects->removeElement($actionObject)) {
            // set the owning side to null (unless already changed)
            if ($actionObject->getObject() === $this) {
                $actionObject->setObject(null);
            }
        }

        return $this;
    }
}
