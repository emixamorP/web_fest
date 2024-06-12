<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Groupe::class, mappedBy: 'etablissement')]
    private Collection $groupes;

    #[ORM\Column]
    private ?int $nbrChambres = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbrGroupesAccueillis = null;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Groupe>
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function getNbrChambres(): ?int
    {
        return $this->nbrChambres;
    }

    public function setNbrChambres(int $nbrChambres): static
    {
        $this->nbrChambres = $nbrChambres;

        return $this;
    }

    public function getNbrGroupesAccueillis(): ?int
    {
        return $this->nbrGroupesAccueillis;
    }

    public function setNbrGroupesAccueillis(?int $nbrGroupesAccueillis): static
    {
        $this->nbrGroupesAccueillis = $nbrGroupesAccueillis;

        return $this;
    }

    public function getChambresRestantes()
    {
        $totalUsers = array_reduce($this->groupes->toArray(), function($carry, $groupe) {
            return $carry + $groupe->getNbUsersInscrits();
        }, 0);

        return $this->nbrChambres - $totalUsers;
    }
   
}
