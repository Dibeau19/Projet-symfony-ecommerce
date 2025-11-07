<?php

namespace App\Entity;

use App\Repository\PullRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PullRepository::class)]
class Pull extends Produit
{
    #[ORM\Column(length: 255)]
    private ?string $taille = null;

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;
        return $this;
    }
}
