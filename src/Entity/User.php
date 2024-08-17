<?php declare(strict_types=1);
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenoms = null;

    #[ORM\Column(length: 255)]
    private ?string $entreprise = null;

    #[ORM\Column(length: 255)]
    private ?string $responsable = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified = false;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $verificationToken = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: NatureProjet::class)]
    private Collection $natureProjets;

    public function getNatureProjets(): Collection
    {
        return $this->natureProjets;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TypeEtablissement::class)]
    private Collection $TypeEtablissement;

    public function getTypeEtablissement(): Collection
    {
        return $this->TypeEtablissement;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TypeActivite::class)]
    private Collection $TypeActivite;

    public function getTypeActivite(): Collection
    {
        return $this->TypeActivite;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LieuImplantation::class)]
    private Collection $LieuImplantation;

    public function getLieuImplantation(): Collection
    {
        return $this->LieuImplantation;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Environnement::class)]
    private Collection $Environnement;

    public function getEnvironnement(): Collection
    {
        return $this->Environnement;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TypeConstruction::class)]
    private Collection $TypeConstruction;

    public function getTypeConstruction(): Collection
    {
        return $this->TypeConstruction;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PlanMasse::class)]
    private Collection $PlanMasse;

    public function getPlanMasse(): Collection
    {
        return $this->PlanMasse;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CasDeLocation::class)]
    private Collection $casDeLocation;

    public function getCasDeLocation(): Collection
    {
        return $this->casDeLocation;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CategorieClassement::class)]
    private Collection $categorieClassement;

    public function getCategorieClassement(): Collection
    {
        return $this->categorieClassement;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: GroupeActivite::class)]
    private Collection $GroupeActivite;

    public function getGroupeActivite(): Collection
    {
        return $this->GroupeActivite;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ActiviteHotel::class)]
    private Collection $ActiviteHotel;

    public function getActiviteHotel(): Collection
    {
        return $this->ActiviteHotel;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RenseignementCIN::class)]
    private Collection $RenseignementCIN;

    public function getRenseignementCIN(): Collection
    {
        return $this->RenseignementCIN;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RenseignementVisa::class)]
    private Collection $RenseignementVisa;

    public function getRenseignementVisa(): Collection
    {
        return $this->RenseignementVisa;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RenseignementIndividuelle::class)]
    private Collection $RenseignementIndividuelle;

    public function getRenseignementIndividuelle(): Collection
    {
        return $this->RenseignementIndividuelle;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RenseignementResponsable::class)]
    private Collection $RenseignementResponsable;

    public function getRenseignementResponsable(): Collection
    {
        return $this->RenseignementResponsable;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RenseignementTypeEntreprise::class)]
    private Collection $RenseignementTypeEntreprise;

    public function getRenseignementTypeEntreprise(): Collection
    {
        return $this->RenseignementTypeEntreprise;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RenseignementEntreprise::class)]
    private Collection $RenseignementEntreprise;

    public function getRenseignementEntreprise(): Collection
    {
        return $this->RenseignementEntreprise;
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function setVerificationToken(?string $verificationToken): self
    {
        $this->verificationToken = $verificationToken;

        return $this;
    }

    // Implement methods required by UserInterface
    public function getRoles(): array
    {
        // Return an array of roles assigned to the user
        // Example: return ['ROLE_USER'];
        return [];
    }

    public function getSalt(): ?string
    {
        // Return null if you're using bcrypt or argon2i for password hashing
        return null;
    }

    public function getUserIdentifier(): string
    {
        // Return the unique identifier for the user (usually email)
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary data on the user, clear it here
    }
}
