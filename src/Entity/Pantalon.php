<?php

namespace App\Entity;

use App\Repository\PantalonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PantalonRepository::class)]
class Pantalon extends Produit
{
    #[ORM\Column(length: 255)]
    private ?int $taille = null;

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;
        return $this;
    }
}
