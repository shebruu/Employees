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
    #[ORM\JoinColumn(name: "emp_no", referencedColumnName: "emp_no")]
    private  $emp_no = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Departement::class)]
    #[ORM\JoinColumn(name: "dept_no", referencedColumnName: "dept_no")]
    private ?string $dept_no = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $from_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $to_date = null;



    public function getEmpNo(): ?int
    {
        return $this->emp_no;
    }

    public function setEmpNo(int $emp_no): static
    {
        $this->emp_no = $emp_no;

        return $this;
    }

    public function getDeptNo(): ?string
    {
        return $this->dept_no;
    }

    public function setDeptNo(string $dept_no): static
    {
        $this->dept_no = $dept_no;

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
