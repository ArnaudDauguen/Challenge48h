<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="deliveries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ShoppingList", mappedBy="delivery")
     */
    private $ShoppingLists;

    public function __construct()
    {
        $this->ShoppingLists = new ArrayCollection();
    }

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

    /**
     * @return Collection|ShoppingList[]
     */
    public function getShoppingLists(): Collection
    {
        return $this->ShoppingLists;
    }

    public function addShoppingList(ShoppingList $shoppingList): self
    {
        if (!$this->ShoppingLists->contains($shoppingList)) {
            $this->ShoppingLists[] = $shoppingList;
            $shoppingList->setDelivery($this);
        }

        return $this;
    }

    public function removeShoppingList(ShoppingList $shoppingList): self
    {
        if ($this->ShoppingLists->contains($shoppingList)) {
            $this->ShoppingLists->removeElement($shoppingList);
            // set the owning side to null (unless already changed)
            if ($shoppingList->getDelivery() === $this) {
                $shoppingList->setDelivery(null);
            }
        }

        return $this;
    }

    public function isComplete() : bool
    {
        foreach($this->ShoppingLists as $shoppingList){
            if(!$shoppingList->isDelivered())
                return false;
        }
        return true;
    }
    public function getDeliveryDate(): ?string
    {
        foreach($this->ShoppingLists as $shoppingList){
            if(!empty($shoppingList->getDeliveredAt()))
                return $shoppingList->getDeliveredAt()->format('Y-m-d');
        }
        return "never";
    }
}
