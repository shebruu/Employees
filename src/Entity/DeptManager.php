<?php

namespace App\Entity;

use App\Repository\DeptManagerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeptManagerRepository::class)]
class DeptManager
{

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'deptManagers')]
    #[ORM\JoinColumn(name: 'department_id', referencedColumnName: 'id', nullable: false)]
    private ?Departement $departement = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'deptManagers')]
    #[ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'id', nullable: false)]
    private ?Employee $employee = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deptName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fromDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $toDate = null;



    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDeptName(): ?string
    {
        return $this->deptName;
    }

    public function setDeptName(?string $deptName): static
    {
        $this->deptName = $deptName;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(?\DateTimeInterface $fromDate): static
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(?\DateTimeInterface $toDate): static
    {
        $this->toDate = $toDate;

        return $this;
    }
}
