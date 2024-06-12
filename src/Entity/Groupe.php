<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
class Groupe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column]
    private ?int $nombreMaximum = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'groupes')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'groupesChef')]
    private ?User $chef = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?Etablissement $etablissement = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getNombreMaximum(): ?int
    {
        return $this->nombreMaximum;
    }

    public function setNombreMaximum(int $nombreMaximum): static
    {
        $this->nombreMaximum = $nombreMaximum;

        return $this;
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
            $user->addGroupe($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeGroupe($this);
        }

        return $this;
    }

    public function getChef(): ?User
    {
        return $this->chef;
    }

    public function setChef(?User $chef): static
    {
        $this->chef = $chef;

        return $this;
    }
    
    public function getPlacesRestantes(): int
    {
        return $this->nombreMaximum - $this->users->count();
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(?Etablissement $etablissement): static
    {
        $this->etablissement = $etablissement;

        return $this;
    }
}