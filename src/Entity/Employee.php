<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

enum Gender: string
{
    case Homme = 'M';
    case Femme = 'F';
    case Non_Binary = 'X';
}

#[ORM\Table('employees')]
#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(name: 'id')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 14)]
    #[Assert\Length(min: 3, max: 14)]
    private ?string $firstName = null;

    #[ORM\Column(length: 16)]
    #[Assert\Length(min: 3, max: 16)]
    private ?string $lastName = null;

    #[ORM\Column(length: 1, enumType: Gender::class)]
    private ?Gender $gender = null;








    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $hireDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Demand::class)]
    private Collection $demands;



    // Relation many-to-many directe avec Department
    #[ORM\ManyToMany(targetEntity: Departement::class, inversedBy: 'employees')]
    #[ORM\JoinTable(
        name: "dept_emp",
        joinColumns: [new ORM\JoinColumn(name: "employee_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "department_id", referencedColumnName: "id")]
    )]
    private Collection $departments;

    // Relation one-to-many avec l'entité de jointure DeptEmp
    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: DeptEmp::class)]
    private Collection $deptEmps;



    #[ORM\Column]
    private array $roles = [];


    public  $ctrl_actualDept;

    public $repoqb_actualDept;

    public $actualdep;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public function __construct()
    {
        $this->demands = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->deptEmps = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getHireDate(): ?\DateTimeInterface
    {
        return $this->hireDate;
    }

    public function setHireDate(\DateTimeInterface $hireDate): static
    {
        $this->hireDate = $hireDate;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function __toString(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }


    /**
     * @return Collection<int, Demand>
     */
    public function getDemands(): Collection
    {
        return $this->demands;
    }

    public function addDemand(Demand $demand): static
    {
        if (!$this->demands->contains($demand)) {
            $this->demands->add($demand);
            $demand->setEmploye($this);
        }

        return $this;
    }




    public function removeDemand(Demand $demand): static
    {
        if ($this->demands->removeElement($demand)) {
            // set the owning side to null (unless already changed)
            if ($demand->getEmploye() === $this) {
                $demand->setEmploye(null);
            }
        }

        return $this;
    }

    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function getDeptEmps(): Collection
    {
        return $this->deptEmps;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isAdmin(): bool
    {
        return in_array('ROLE_ADMIN', $this->roles);
    }

    public function getCtrlActualDept()
    {
        return $this->ctrl_actualDept;
    }

    public function setCtrlActualDept($ctrl_actualDept)
    {
        $this->ctrl_actualDept = $ctrl_actualDept;
    }

    public function repoqb_actualDept($repoqb_actualDept)
    {
        $this->repoqb_actualDept = $repoqb_actualDept;
    }
}
