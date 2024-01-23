<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Table('departments')]
#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?string $id = null;


    #[ORM\Column(length: 4, name: 'dept_no')]
    private ?string $dept_no = null;

    #[ORM\Column(length: 40, name: 'dept_name')]
    private ?string $dept_name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $roi_url = null;


    // Relation many-to-many inverse avec Employee
    #[ORM\ManyToMany(targetEntity: Employee::class, mappedBy: 'departments')]
    private Collection $employees;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: DeptEmp::class)]
    private Collection $deptEmps;

    #[ORM\OneToMany(mappedBy: 'deptNo', targetEntity: Intern::class)]
    private Collection $interns;


    public function __construct()
    {
        $this->employees = new ArrayCollection();
        $this->deptEmps = new ArrayCollection();
        $this->interns = new ArrayCollection();
    }
    public function getId(): ?string
    {
        return $this->id;
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

    public function getDeptName(): ?string
    {


        return $this->dept_name;
    }



    public function setDeptName(string $dept_name): static
    {
        $this->dept_name = $dept_name;

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

    public function getAdress(): ?string
    {
        return $this->address;
    }

    public function setAdress(string $adress): static
    {
        $this->address = $adress;

        return $this;
    }

    public function getRoiUrl(): ?string
    {
        return $this->roi_url;
    }

    public function setRoiUrl(?string $roi_url): static
    {
        $this->roi_url = $roi_url;

        return $this;
    }


    public function __toString()
    {
        return $this->dept_name;
    }

    /**
     * @return Collection<int, Intern>
     */
    public function getInterns(): Collection
    {
        return $this->interns;
    }

    public function addIntern(Intern $intern): static
    {
        if (!$this->interns->contains($intern)) {
            $this->interns->add($intern);
            $intern->setDeptNo($this);
        }

        return $this;
    }

    public function removeIntern(Intern $intern): static
    {
        if ($this->interns->removeElement($intern)) {
            // set the owning side to null (unless already changed)
            if ($intern->getDeptNo() === $this) {
                $intern->setDeptNo(null);
            }
        }

        return $this;
    }
}
