<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CarsRepository::class)]
#[UniqueEntity('name')]

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarsRepository")
 * @UniqueEntity(fields={"name"}, message="Ce nom de produit est déjà utilisé.")
 */

class Cars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, max:255)]
    #[Assert\NotBlank()]
    private ?string $Name = null;


    #[ORM\ManyToOne(inversedBy: 'Cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Color $color = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    private ?int $Power = null;

    /* #[ORM\Column(length: 255, nullable: true)]
    private ?string $Energy = null; */

    #[ORM\ManyToOne(inversedBy: 'Cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Energy $energy = null;

    #[ORM\ManyToOne(inversedBy: 'Cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Brand $brand = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $DateCreation = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column]
    #[Assert\Positive()]
    #[Assert\LessThan(10500000)]
    private ?int $Price = null;



    #[ORM\Column(nullable: true)]
    #[Assert\Positive()]
    #[Assert\Length(min: 3, max:8)]
    private ?int $NbDoor = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CT = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AdressProduct = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }


    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): static
    {
        $this->color = $color;

        return $this;
    }


    public function getPower(): ?int
    {
        return $this->Power;
    }

    public function setPower(?int $Power): static
    {
        $this->Power = $Power;

        return $this;
    }

    /*     public function getEnergy(): ?string
    {
        return $this->Energy;
    }

    public function setEnergy(?string $Energy): static
    {
        $this->Energy = $Energy;

        return $this;
    } */

    public function getEnergy(): ?Energy
    {
        return $this->energy;
    }

    public function setEnergy(?Energy $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $DateCreation): static
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->Price;
    }

    public function setPrice(int $Price): static
    {
        $this->Price = $Price;

        return $this;
    }



    public function getNbDoor(): ?int
    {
        return $this->NbDoor;
    }

    public function setNbDoor(?int $NbDoor): static
    {
        $this->NbDoor = $NbDoor;

        return $this;
    }

    public function isCT(): ?bool
    {
        return $this->CT;
    }

    public function setCT(?bool $CT): static
    {
        $this->CT = $CT;

        return $this;
    }

    public function getAdressProduct(): ?string
    {
        return $this->AdressProduct;
    }

    public function setAdressProduct(?string $AdressProduct): static
    {
        $this->AdressProduct = $AdressProduct;

        return $this;
    }
}
