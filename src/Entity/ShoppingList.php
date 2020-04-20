<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingListRepository")
 */
class ShoppingList
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="shoppingLists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expectedDeliveryStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expectedDeliveryEnd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recipe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasClientAccepted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hasDeliveryAccepted;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deliveredAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Delivery", inversedBy="ShoppingLists")
     */
    private $delivery;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductsList", mappedBy="shoppingList", orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getExpectedDeliveryStart(): ?\DateTimeInterface
    {
        return $this->expectedDeliveryStart;
    }

    public function setExpectedDeliveryStart(\DateTimeInterface $expectedDeliveryStart): self
    {
        $this->expectedDeliveryStart = $expectedDeliveryStart;

        return $this;
    }

    public function getExpectedDeliveryEnd(): ?\DateTimeInterface
    {
        return $this->expectedDeliveryEnd;
    }

    public function setExpectedDeliveryEnd(\DateTimeInterface $expectedDeliveryEnd): self
    {
        $this->expectedDeliveryEnd = $expectedDeliveryEnd;

        return $this;
    }

    public function getRecipe(): ?string
    {
        return $this->recipe;
    }

    public function setRecipe(?string $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getHasClientAccepted(): ?bool
    {
        return $this->hasClientAccepted;
    }

    public function setHasClientAccepted(?bool $hasClientAccepted): self
    {
        $this->hasClientAccepted = $hasClientAccepted;

        return $this;
    }

    public function getHasDeliveryAccepted(): ?bool
    {
        return $this->hasDeliveryAccepted;
    }

    public function setHasDeliveryAccepted(?bool $hasDeliveryAccepted): self
    {
        $this->hasDeliveryAccepted = $hasDeliveryAccepted;

        return $this;
    }

    public function getDeliveredAt(): ?\DateTimeInterface
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(?\DateTimeInterface $deliveredAt): self
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }

    public function getDelivery(): ?Delivery
    {
        return $this->delivery;
    }

    public function setDelivery(?Delivery $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection|ProductsList[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(ProductsList $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setShoppingList($this);
        }

        return $this;
    }

    public function removeProduct(ProductsList $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getShoppingList() === $this) {
                $product->setShoppingList(null);
            }
        }

        return $this;
    }
}
