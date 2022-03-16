<?php

namespace App\Entity;

use App\Repository\VariantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VariantRepository::class)]
class Variant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string')]
    private string $sku;

    #[ORM\Column(type: 'float')]
    private ?float $price;

    #[ORM\Column(type: 'string')]
    private string $color;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Product::class, cascade: ['persist'], inversedBy: 'variants')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
    private Product $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
