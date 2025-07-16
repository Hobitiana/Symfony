<?php 
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
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

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenoms = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $codepostal = null;
    
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $entreprise = null;

 

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

    #[ORM\Column(type: "json")]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: NatureOuvrage::class)]
    private Collection $natureOuvrage;

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public function __construct()
    {
        // Initialisation des rôles par défaut
        $this->roles = [self::ROLE_USER]; // Tous les utilisateurs commencent avec le rôle USER
    }

    public function getnatureOuvrage(): Collection
    {
        return $this->natureOuvrage;
    }

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
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Document::class)]
    private Collection $Document;

    public function getDocument(): Collection
    {
        return $this->Document;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: EnregistrementDeMaDemande::class)]
    private Collection $EnregistrementDeMaDemande;

    public function getEnregistrementDeMaDemande(): Collection
    {
        return $this->EnregistrementDeMaDemande;
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
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: RelationActivite::class)]
    private Collection $RelationActivite;

    public function getRelationActivite(): Collection
    {
        return $this->RelationActivite;
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

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionRestaurant::class)]
    private Collection $DescriptionRestaurant;

    public function getDescriptionRestaurant(): Collection
    {
        return $this->DescriptionRestaurant;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionQuestionRestaurant::class)]
    private Collection $DescriptionQuestionRestaurant;

    public function getDescriptionQuestionRestaurant(): Collection
    {
        return $this->DescriptionQuestionRestaurant;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Demande::class)]
    private Collection $Demande;

    public function getDemande(): Collection
    {
        return $this->Demande;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionQuestionChoixRestaurant::class)]
    private Collection $DescriptionQuestionChoixRestaurant;

    public function getDescriptionQuestionChoixRestaurant(): Collection
    {
        return $this->DescriptionQuestionChoixRestaurant;
    }
    
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionHebergement::class)]
    private Collection $DescriptionHebergement;

    public function getDescriptionHebergement(): Collection
    {
        return $this->DescriptionHebergement;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionQuestionHebergement::class)]
    private Collection $DescriptionQuestionHebergement;

    public function getDescriptionQuestionHebergement(): Collection
    {
        return $this->DescriptionQuestionHebergement;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionQuestionChoixHebergement::class)]
    private Collection $DescriptionQuestionChoixHebergement;

    public function getDescriptionQuestionChoixHebergement(): Collection
    {
        return $this->DescriptionQuestionChoixHebergement;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionTypeDeDemande::class)]
    private Collection $DescriptionTypeDeDemande;

    public function getDescriptionTypeDeDemande(): Collection
    {
        return $this->DescriptionTypeDeDemande;
    }

    //Camping
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionCamping::class)]
    private Collection $DescriptionCamping;

    public function getDescriptionCamping(): Collection
    {
        return $this->DescriptionCamping;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionQuestionCamping::class)]
    private Collection $DescriptionQuestionCamping;

    public function getDescriptionQuestionCamping(): Collection
    {
        return $this->DescriptionQuestionCamping;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DescriptionQuestionChoixCamping::class)]
    private Collection $DescriptionQuestionChoixCamping;

    public function getDescriptionQuestionChoixCamping(): Collection
    {
        return $this->DescriptionQuestionChoixCamping;
    }
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: DesignationReference::class)]
    private Collection $DesignationReference;

    public function getDesignationReference(): Collection
    {
        return $this->DesignationReference;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ResultatDemande::class)]
    private Collection $ResultatDemande;

    public function getResultatDemande(): Collection
    {
        return $this->ResultatDemande;
    }

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UploadAvisOuverture::class)]
    private Collection $UploadAvisOuverture;

    public function getUploadAvisOuverture(): Collection
    {
        return $this->UploadAvisOuverture;
    }


    public function __toString(): string
    {
        return $this->email;
    }
        public function getRoles(): array
    {
        // Retourne tous les rôles, s'assurant que ROLE_USER est toujours présent
        return array_unique(array_merge($this->roles, [self::ROLE_USER]));
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function isAdmin(): bool
    {
        return in_array(self::ROLE_ADMIN, $this->roles);
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

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }
    public function getRegion(): ?string
    {
        return $this->region;
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

    public function setIsVerified(bool $isVerified): self
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
