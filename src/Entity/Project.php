<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use DateTime;
use Symfony\Component\Config\Definition\Dumper\XmlReferenceDumper;

#[ORM\Table('projets')]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'chef_projet', referencedColumnName: 'id')]
    private ?Employee $chefDeProjet = null;

    #[ORM\ManyToMany(targetEntity: Employee::class, inversedBy: "projetsAssignes")]
    #[ORM\JoinTable(name: "project_employee")]
    private Collection $employees;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime', name: 'date_creation')]
    private ?\DateTime $creation = null;

    #[ORM\Column(nullable: true, name: 'modified')]
    private ?bool $estmodifie = null;




    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployees(): Collection
    {
        return $this->employees;
    }
    /**
     * ajoute un employé a la collection( liste) d employés travaillant sur ce projet 
     */
    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            //
            // Met à jour la relation inverse ( ajoute ce projet a la liste des projets assigné de l employé)
            $employee->addProjetsAssignes($this);
        }
        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            $employee->removeProjetsAssignes($this);
        }
        return $this;
    }
    public function getChefDeProjet(): ?Employee
    {
        return $this->chefDeProjet;
    }


    public function setChefDeProjet(?Employee $chefDeProjet): static
    {
        $this->chefDeProjet = $chefDeProjet;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(\DateTimeInterface $creation): static
    {
        $this->creation = $creation;

        return $this;
    }

    public function isEstmodifie(): ?bool
    {
        return $this->estmodifie;
    }

    public function setEstmodifie(?bool $estmodifie): static
    {
        $this->estmodifie = $estmodifie;

        return $this;
    }
}
