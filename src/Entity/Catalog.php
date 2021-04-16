<?php

namespace App\Entity;

use App\Repository\CatalogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CatalogRepository::class)
 */
class Catalog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="catalogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propertyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propertyValue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propertyNameAr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $propertyValueAr;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    public function setPropertyName(string $propertyName): self
    {
        $this->propertyName = $propertyName;

        return $this;
    }

    public function getPropertyValue(): ?string
    {
        return $this->propertyValue;
    }

    public function setPropertyValue(string $propertyValue): self
    {
        $this->propertyValue = $propertyValue;

        return $this;
    }

    public function getPropertyNameAr(): ?string
    {
        return $this->propertyNameAr;
    }

    public function setPropertyNameAr(string $propertyNameAr): self
    {
        $this->propertyNameAr = $propertyNameAr;

        return $this;
    }

    public function getPropertyValueAr(): ?string
    {
        return $this->propertyValueAr;
    }

    public function setPropertyValueAr(string $propertyValueAr): self
    {
        $this->propertyValueAr = $propertyValueAr;

        return $this;
    }
}
