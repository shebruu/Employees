<?php

namespace App\Entity;

use App\Repository\EmpTitleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table('emp_title')]
#[ORM\Entity(repositoryClass: EmpTitleRepository::class)]
class EmpTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name:"emp_no")]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $titleNo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fromDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $toDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleNo(): ?int
    {
        return $this->titleNo;
    }

    public function setTitleNo(int $titleNo): static
    {
        $this->titleNo = $titleNo;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeInterface $fromDate): static
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeInterface $toDate): static
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function __toString(): string {
        return "{$this->fromDate} {$this->toDate}";
    }
}
