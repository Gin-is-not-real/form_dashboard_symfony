<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $advice;

    /**
     * @ORM\Column(type="date")
     */
    private $purchase_date;

    /**
     * @ORM\Column(type="date")
     */
    private $warranty_end_purchase;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="products")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=Manual::class, cascade={"persist", "remove"})
     */
    private $manual;

    /**
     * @ORM\OneToOne(targetEntity=Receipt::class, cascade={"persist", "remove"})
     */
    private $receipt;

    public function __construct()
    {
        $this->category = new ArrayCollection();
    }

    public function __toString() {
        return $this->name;
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

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAdvice(): ?string
    {
        return $this->advice;
    }

    public function setAdvice(string $advice): self
    {
        $this->advice = $advice;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(\DateTimeInterface $purchase_date): self
    {
        $this->purchase_date = $purchase_date;

        return $this;
    }

    public function getWarrantyEndPurchase(): ?\DateTimeInterface
    {
        return $this->warranty_end_purchase;
    }

    public function setWarrantyEndPurchase(\DateTimeInterface $warranty_end_purchase): self
    {
        $this->warranty_end_purchase = $warranty_end_purchase;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getManual(): ?Manual
    {
        return $this->manual;
    }

    public function setManual(?Manual $manual): self
    {
        $this->manual = $manual;

        return $this;
    }

    // public function addManual(Manual $manual): self {
    //     return $this;
    // }

    public function getReceipt(): ?Receipt
    {
        return $this->receipt;
    }

    public function setReceipt(?Receipt $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }
}
