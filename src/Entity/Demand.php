<?php

namespace App\Entity;

use App\Repository\DemandRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table('demands')]
#[ORM\Entity(repositoryClass: DemandRepository::class)]
class Demand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $type = null;

    #[ORM\Column(length: 15)]
    private ?string $about = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'demands')]
    #[ORM\JoinColumn(name:"emp_no", referencedColumnName:"emp_no",nullable: false)]
    private ?Employee $employee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): static
    {
        $this->about = $about;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): static
    {
        $this->status = $status;

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
}
