<?php

namespace App\Entity;

use App\Repository\DeptEmpRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table('dept_emp')]
#[ORM\Entity(repositoryClass: DeptEmpRepository::class)]
class DeptEmp
{


    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'deptEmps')]
    #[ORM\JoinColumn(name: 'employee_id', referencedColumnName: 'id', nullable: false)]
    private ?Employee $employee = null;


    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'deptEmps')]
    #[ORM\JoinColumn(name: 'department_id', referencedColumnName: 'id', nullable: false)]
    private ?Departement $departement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $from_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $to_date = null;





    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee): static
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(Departement $departement): static
    {
        $this->departement = $departement;


        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {

        return $this->from_date;
    }

    public function setFromDate(\DateTimeInterface $from_date): static
    {
        $this->from_date = $from_date;


        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {

        return $this->to_date;
    }

    public function setToDate(\DateTimeInterface $to_date): static
    {
        $this->to_date = $to_date;

        return $this;
    }

    public function __toString(): string
    {
        return "{$this->from_date} {$this->to_date}";
    }
}
