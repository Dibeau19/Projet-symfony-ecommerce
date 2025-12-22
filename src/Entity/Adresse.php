<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection; // Import nécessaire
use Doctrine\Common\Collections\Collection;      // Import nécessaire
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column]
    private ?int $code_postal = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'adresses')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function getRue():?string 
    { 
        return $this->rue; 
    }
    public function setRue(string $rue): static 
    { 
        $this->rue = $rue; return $this; 
    }
    public function getCodePostal(): ?int 
    { 
        return $this->code_postal; 
    }
    public function setCodePostal(int $code_postal): static 
    { 
        $this->code_postal = $code_postal; return $this; 
    }
    public function getVille(): ?string 
    { 
        return $this->ville; 
    }
    public function setVille(string $ville): static 
    { 
        $this->ville = $ville; return $this; 
    }
    public function getPays(): ?string 
    { 
        return $this->pays; 
    }
    public function setPays(string $pays): static 
    { 
        $this->pays = $pays; return $this; 
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAdresse($this); 
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeAdresse($this); 
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->rue . ' ' . $this->code_postal . ' ' . $this->ville;
    }
}