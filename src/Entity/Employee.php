<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

enum Gender: string
{
    case Homme = 'M';
    case Femme = 'F';
    case Non_Binary = 'X';
}



/**
 * Représente un employé dans le système.
 *
 */
#[ORM\Table('collaborators')]
#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{

    /**
     * Identiiant unique de l'employé.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(name: 'id')]
    private ?int $id = null;

    /**
     *
     * Date de naissance de l'employé.
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    /**
     * Prénom de l'employé.
     * documment
     */
    #[ORM\Column(length: 14, name: 'firstname')]
    #[Assert\Length(min: 3, max: 14)]
    private ?string $firstName = null;

    /**
     * Nom de famille de l'employé.
     */
    #[ORM\Column(length: 16, name: 'lastname')]
    #[Assert\Length(min: 3, max: 16)]
    private ?string $lastName = null;

    /**
     * Genre de l'employé, représenté par un enum (Homme, Femme, Non-Binaire).
     */
    #[ORM\Column(length: 1, enumType: Gender::class)]
    private ?Gender $gender = null;



    /**
     * Date d'embauche de l'employé.
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $hireDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * Demandes associées à l'employé.
     */
    #[ORM\OneToMany(mappedBy: 'employe', targetEntity: Demand::class)]
    private Collection $demands;



    /** 
     * Départements associés à l'employé.
     */
    #[ORM\ManyToMany(targetEntity: Departement::class, inversedBy: 'employees')]
    #[ORM\JoinTable(
        name: "dept_emp",
        joinColumns: [new ORM\JoinColumn(name: "employee_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "department_id", referencedColumnName: "id")]
    )]
    private Collection $departments;

    /**
     *Relations de l'employé avec les départements (via l'entité de jointure DeptEmp).
     */
    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: DeptEmp::class)]
    private Collection $deptEmps;




    /**
     * Projets dont cet employé est le chef de projet.
     */
    #[ORM\OneToMany(targetEntity: "Project", mappedBy: "chefDeProjet")]
    private Collection $projetschef;


    /** 
     * Projets auxquels cet employé est assigné.
     */
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: "employees")]
    private Collection $projetsAssignes;

    /** 
     * Rôles de l'employé dans l'application.
     */
    #[ORM\Column]
    private array $roles = [];


    #[ORM\Column]
    private ?bool $isVerified = null;
    /**
     * @var string|null Département actuel de l'employé (contrôle).
     */
    public  $ctrl_actualDept;

    /**
     * @var string|null Département actuel de l'employé (requête).
     */
    public $repoqb_actualDept;

    /**
     * @var string|null Département actuel de l'employé.
     */
    public $actualdep;

    /**
     * @var string Mot de passe hashé de l'employé.
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * Missions auxquelles l'employé est associé.
     */
    #[ORM\ManyToMany(targetEntity: Mission::class, inversedBy: 'employees')]
    #[ORM\JoinTable(
        name: "employee_mission",
        joinColumns: [new ORM\JoinColumn(name: "employee_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "mission_id", referencedColumnName: "id")]
    )]
    private Collection $missions;




    #[ORM\OneToMany(mappedBy: 'superviseur', targetEntity: Intern::class)]
    private Collection $interns;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: DeptManager::class)]
    private Collection $deptManagers;

    public function __construct()
    {
        $this->demands = new ArrayCollection();
        $this->departments = new ArrayCollection();
        $this->deptEmps = new ArrayCollection();

        $this->projetsAssignes = new ArrayCollection();
        $this->projetschef = new ArrayCollection();
        $this->missions = new ArrayCollection();

        $this->interns = new ArrayCollection();
        $this->deptManagers = new ArrayCollection();
    }


    /**
     * Ajoute un projet à la liste des projets assignés à cet employé.
     *
     * @param Project $projet Le projet à ajouter.
     * @return self Retourne l'instance de l'employé pour permettre le chaînage des méthodes.
     */
    public function addProjetsAssignes(Project $projet): self
    {
        if (!$this->projetsAssignes->contains($projet)) {
            $this->projetsAssignes[] = $projet;
            $projet->addEmployee($this); //doit exister ds les 2 entités ( project aussi)
        }
        return $this;
    }

    /**
     * Supprime un projet de la liste des projets assignés à cet employé.
     * Si le projet est dans la liste, il est retiré et l'association entre l'employé et le projet est supprimée.
     *
     * @param Project $projet Le projet à retirer.
     * @return self Retourne l'instance de l'employé pour permettre le chaînage des méthodes.
     */
    public function removeProjetsAssignes(Project $projet): self
    {
        if ($this->projetsAssignes->removeElement($projet)) {
            $projet->removeEmployee($this);
        }
        return $this;
    }


    /**
     * Récupère l'identifiant de l'employé.
     */
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


    /**
     * Récupère la collection des demandes associées à cet employé.
     * 
     * @return Collection<int, Demand> La collection des demandes.
     */
    public function getDemands(): Collection
    {
        return $this->demands;
    }


    /**
     * Ajoute une demande à la collection des demandes de cet employé.
     *
     * @param Demand $demand La demande à ajouter.
     * @return self Retourne l'instance de l'employé pour permettre le chaînage des méthodes.
     */
    public function addDemand(Demand $demand): static
    {
        if (!$this->demands->contains($demand)) {
            $this->demands->add($demand);
            $demand->setEmploye($this);
        }

        return $this;
    }



    /**
     * Supprime une demande de la collection des demandes de cet employé.
     * Si la demande est présente dans la collection, elle est retirée.
     *
     * @param Demand $demand La demande à retirer.
     * @return self Retourne l'instance de l'employé pour permettre le chaînage des méthodes.
     */
    public function removeDemand(Demand $demand): static
    {
        if ($this->demands->removeElement($demand)) {

            if ($demand->getEmploye() === $this) {
                $demand->setEmploye(null);
            }
        }

        return $this;
    }

    /**
     * Récupère la collection des départements associés à cet employé.
     * 
     * @return Collection La collection des départements.
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    /**
     * Récupère la collection des relations DeptEmp associées à cet employé.
     * 
     * @return Collection La collection des relations DeptEmp.
     */
    public function getDeptEmps(): Collection
    {
        return $this->deptEmps;
    }

    /**
     * @see UserInterface
     *
     * Retourne l'identifiant de l'utilisateur ( l'email).
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * Retourne les rôles de l'utilisateur.
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

    /**
     * @return Collection<int, mission>
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(mission $mission): static
    {
        if (!$this->missions->contains($mission)) {
            $this->missions->add($mission);
        }

        return $this;
    }

    public function removeMission(mission $mission): static
    {
        $this->missions->removeElement($mission);

        return $this;
    }




    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
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
            $intern->setsuperviseur($this);
        }

        return $this;
    }

    public function removeIntern(Intern $intern): static
    {
        if ($this->interns->removeElement($intern)) {
            // set the owning side to null (unless already changed)
            if ($intern->getSuperviseur() === $this) {
                $intern->setsuperviseur(null);
            }
        }

        return $this;
    }

    /**
     * Récupère la liste de tous les projets assignés à cet employé.
     *
     * @return Collection<Project> La collection des projets assignés.
     */
    public function getAllAssignedProjects(): Collection
    {
        $allAssignedProjects = new ArrayCollection();

        foreach ($this->projetsAssignes as $project) {
            $allAssignedProjects[] = $project;
        }

        return $allAssignedProjects;
    }

    /**
     * Représentation en chaîne de caractères de l'employé ( pour l affichage) .
     * 
     * @return string Une chaîne de caractères représentant l'employé (prénom et nom).
     */
    public function __toString(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * @return Collection<int, DeptManager>
     */
    public function getDeptManagers(): Collection
    {
        return $this->deptManagers;
    }

    public function addDeptManager(DeptManager $deptManager): static
    {
        if (!$this->deptManagers->contains($deptManager)) {
            $this->deptManagers->add($deptManager);
            $deptManager->setEmployee($this);
        }

        return $this;
    }

    public function removeDeptManager(DeptManager $deptManager): static
    {
        if ($this->deptManagers->removeElement($deptManager)) {
            // set the owning side to null (unless already changed)
            if ($deptManager->getEmployee() === $this) {
                $deptManager->setEmployee(null);
            }
        }

        return $this;
    }
}
