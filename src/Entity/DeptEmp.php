<?php

namespace App\Entity;

use App\Repository\DeptEmpRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeptEmpRepository::class)]
class DeptEmp
{

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: "employee_id", referencedColumnName: "id")]
    private  $employee_id = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Departement::class)]
    #[ORM\JoinColumn(name: "department_id", referencedColumnName: "id")]
    private ?string $department_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $from_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $to_date = null;





    public function getEmpid(): ?int
    {
        return $this->employee_id;
    }

    public function setEmpid(int $employee_id): static
    {
        $this->employee_id = $employee_id;

        return $this;
    }

    public function getDeptid(): ?string
    {
        return $this->department_id;
    }

    public function setDeptid(string $departement_id): static
    {
        $this->department_id = $departement_id;

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
}
