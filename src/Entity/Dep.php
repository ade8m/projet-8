<?php

namespace App\Entity;

use App\Repository\DepRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepRepository::class)]
class Dep
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomdep = null;

    #[ORM\Column(length: 255)]
    private ?string $responsable = null;

    #[ORM\Column]
    private ?int $nbrsalaire = null;

    #[ORM\OneToMany(mappedBy: 'dep', targetEntity: emp::class)]
    private Collection $emp;

    public function __construct()
    {
        $this->emp = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomdep(): ?string
    {
        return $this->nomdep;
    }

    public function setNomdep(string $nomdep): self
    {
        $this->nomdep = $nomdep;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getNbrsalaire(): ?int
    {
        return $this->nbrsalaire;
    }

    public function setNbrsalaire(int $nbrsalaire): self
    {
        $this->nbrsalaire = $nbrsalaire;

        return $this;
    }

    /**
     * @return Collection<int, emp>
     */
    public function getEmp(): Collection
    {
        return $this->emp;
    }

    public function addEmp(emp $emp): self
    {
        if (!$this->emp->contains($emp)) {
            $this->emp->add($emp);
            $emp->setDep($this);
        }

        return $this;
    }

    public function removeEmp(emp $emp): self
    {
        if ($this->emp->removeElement($emp)) {
            // set the owning side to null (unless already changed)
            if ($emp->getDep() === $this) {
                $emp->setDep(null);
            }
        }

        return $this;
    }
}
