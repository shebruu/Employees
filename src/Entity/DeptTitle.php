<?php

namespace App\Entity;

use App\Repository\DeptTitleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table('dept_title')]
#[ORM\Entity(repositoryClass: DeptTitleRepository::class)]
class DeptTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $deptNo = null;

    #[ORM\Column]
    private ?int $titleNo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeptNo(): ?string
    {
        return $this->deptNo;
    }

    public function setDeptNo(string $deptNo): static
    {
        $this->deptNo = $deptNo;

        return $this;
    }

    public function gettitleNo(): ?int
    {
        return $this->titleNo;
    }

    public function settitleNo(int $titleNo): static
    {
        $this->titleNo = $titleNo;

        return $this;
    }

    public function __toString(): string {
        return "{$this->titleNo}";
    }
}
