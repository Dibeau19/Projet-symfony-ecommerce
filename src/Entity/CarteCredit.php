<?php

namespace App\Entity;

use App\Repository\CarteCreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarteCreditRepository::class)]
class CarteCredit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateExpiration = null;

    #[ORM\Column(length: 4)]
    private ?string $cvv = null;

    #[ORM\ManyToOne(inversedBy: 'cartesCredit')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): static
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function __toString(): string
    {
        // Masquer le numéro sauf les 4 derniers chiffres
        return '**** **** **** ' . substr($this->numero, -4) . ' (' . $this->dateExpiration->format('m/y') . ')';
    }
}
