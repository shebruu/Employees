<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use DateTime;

#[ORM\Table('projets')]
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $emp_no = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime', name: 'date_creation')]
    private ?\DateTime $creation = null;

    #[ORM\Column(nullable: true, name: 'modifié')]
    private ?bool $estmodifie = null;


    #[ORM\ManyToMany(targetEntity: Employee::class)]
    private Collection $employees;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmpNo(): ?int
    {
        return $this->emp_no;
    }

    public function setEmpNo(int $emp_no): static
    {
        $this->emp_no = $emp_no;

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
