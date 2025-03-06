<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $purchasePrice = null;

    #[ORM\Column]
    private ?int $sellingPrice = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $purchaseAt = null;

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPurchasePrice(): ?int
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(?int $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getSellingPrice(): ?int
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(int $sellingPrice): static
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    public function getPurchaseAt(): ?\DateTimeImmutable
    {
        return $this->purchaseAt;
    }

    public function setPurchaseAt(\DateTimeImmutable $purchaseAt): static
    {
        $this->purchaseAt = $purchaseAt;

        return $this;
    }

}
