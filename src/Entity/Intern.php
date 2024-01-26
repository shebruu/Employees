<?php

namespace App\Entity;

use App\Repository\InternRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Table('interns')]
#[ORM\Entity(repositoryClass: InternRepository::class)]
class Intern
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\ManyToOne(inversedBy: 'interns')]
    #[ORM\JoinColumn(name: 'dept_no', referencedColumnName: 'id', nullable: false)]
    private ?Departement $departement = null;

    #[ORM\ManyToOne(inversedBy: 'interns')]
    #[ORM\JoinColumn(name: 'emp_no', referencedColumnName: 'id', nullable: true)]
    private ?Employee $superviseur = null;

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getSuperviseur(): ?Employee
    {
        return $this->superviseur;
    }

    public function setSuperviseur(?Employee $superviseur): static
    {
        $this->superviseur = $superviseur;

        return $this;
    }
}
