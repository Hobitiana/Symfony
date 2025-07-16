<?php


namespace App\Entity;

use App\Repository\MaDemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaDemandeRepository::class)]
class MaDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateActuel = null;


    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?CasDeLocation $idCasDeLocation = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?CategorieClassement $idCategorieClassement = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?LieuImplantation $idLieuImplantation = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?NatureOuvrage $idNatureOuvrage = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?NatureProjet $idNatureProjet = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?PlanMasse $idPlanMasse = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?RelationActivite $idRelationActivite = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $idUsers = null;

    #[ORM\Column(length: 255)]
    private ?string $maTypeDeDemande = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?RenseignementTypeEntreprise $idRenseignementEntreprise = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?RenseignementEntreprise $idRenseignementEntreprises = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?RenseignementIndividuelle $idResneignementIndividuelle = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?RenseignementCIN $idRenseignementCIN = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    #[ORM\JoinColumn(nullable: true)] // Permet à l'attribut d'être null
    private ?RenseignementVisa $idRenseignementVisa = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?Environnement $idEnvironnement = null;

    #[ORM\ManyToOne(inversedBy: 'maDemandes')]
    private ?TypeConstruction $idTypeConstruction = null;

   
    #[ORM\OneToMany(mappedBy: 'idMaDemande', targetEntity: ResponsableDemande::class, cascade: ['persist', 'remove'])]
    private Collection $responsableDemandes;
    
    public function __construct()
    {
        $this->responsableDemandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateActuel(): ?\DateTimeInterface
    {
        return $this->dateActuel;
    }

    public function setDateActuel(\DateTimeInterface $dateActuel): static
    {
        $this->dateActuel = $dateActuel;

        return $this;
    }



    public function getIdCasDeLocation(): ?CasDeLocation
    {
        return $this->idCasDeLocation;
    }

    public function setIdCasDeLocation(?CasDeLocation $idCasDeLocation): static
    {
        $this->idCasDeLocation = $idCasDeLocation;

        return $this;
    }

    public function getIdCategorieClassement(): ?CategorieClassement
    {
        return $this->idCategorieClassement;
    }

    public function setIdCategorieClassement(?CategorieClassement $idCategorieClassement): static
    {
        $this->idCategorieClassement = $idCategorieClassement;

        return $this;
    }

    public function getIdLieuImplantation(): ?LieuImplantation
    {
        return $this->idLieuImplantation;
    }

    public function setIdLieuImplantation(?LieuImplantation $idLieuImplantation): static
    {
        $this->idLieuImplantation = $idLieuImplantation;

        return $this;
    }

    public function getIdNatureOuvrage(): ?NatureOuvrage
    {
        return $this->idNatureOuvrage;
    }

    public function setIdNatureOuvrage(?NatureOuvrage $idNatureOuvrage): static
    {
        $this->idNatureOuvrage = $idNatureOuvrage;

        return $this;
    }

    public function getIdNatureProjet(): ?NatureProjet
    {
        return $this->idNatureProjet;
    }

    public function setIdNatureProjet(?NatureProjet $idNatureProjet): static
    {
        $this->idNatureProjet = $idNatureProjet;

        return $this;
    }

    public function getIdPlanMasse(): ?PlanMasse
    {
        return $this->idPlanMasse;
    }

    public function setIdPlanMasse(?PlanMasse $idPlanMasse): static
    {
        $this->idPlanMasse = $idPlanMasse;

        return $this;
    }

    public function getIdRelationActivite(): ?RelationActivite
    {
        return $this->idRelationActivite;
    }

    public function setIdRelationActivite(?RelationActivite $idRelationActivite): static
    {
        $this->idRelationActivite = $idRelationActivite;

        return $this;
    }

    public function getIdUsers(): ?User
    {
        return $this->idUsers;
    }

    public function setIdUsers(?User $idUsers): static
    {
        $this->idUsers = $idUsers;

        return $this;
    }

    public function getMaTypeDeDemande(): ?string
    {
        return $this->maTypeDeDemande;
    }

    public function setMaTypeDeDemande(string $maTypeDeDemande): static
    {
        $this->maTypeDeDemande = $maTypeDeDemande;

        return $this;
    }
    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getIdRenseignementEntreprise(): ?RenseignementTypeEntreprise
    {
        return $this->idRenseignementEntreprise;
    }

    public function setIdRenseignementEntreprise(?RenseignementTypeEntreprise $idRenseignementEntreprise): static
    {
        $this->idRenseignementEntreprise = $idRenseignementEntreprise;

        return $this;
    }
    public function getIdRenseignementEntreprises(): ?RenseignementEntreprise
    {
        return $this->idRenseignementEntreprises;
    }

    public function setIdRenseignementEntreprises(?RenseignementEntreprise $idRenseignementEntreprises): static
    {
        $this->idRenseignementEntreprises = $idRenseignementEntreprises;

        return $this;
    }
    public function getIdResneignementIndividuelle(): ?RenseignementIndividuelle
    {
        return $this->idResneignementIndividuelle;
    }

    public function setIdResneignementIndividuelle(?RenseignementIndividuelle $idResneignementIndividuelle): static
    {
        $this->idResneignementIndividuelle = $idResneignementIndividuelle;

        return $this;
    }

    public function getIdRenseignementCIN(): ?RenseignementCIN
    {
        return $this->idRenseignementCIN;
    }

    public function setIdRenseignementCIN(?RenseignementCIN $idRenseignementCIN): static
    {
        $this->idRenseignementCIN = $idRenseignementCIN;

        return $this;
    }

    public function getIdRenseignementVisa(): ?RenseignementVisa
    {
        return $this->idRenseignementVisa;
    }

    public function setIdRenseignementVisa(?RenseignementVisa $idRenseignementVisa): static
    {
        $this->idRenseignementVisa = $idRenseignementVisa;

        return $this;
    }

    public function getIdEnvironnement(): ?Environnement
    {
        return $this->idEnvironnement;
    }

    public function setIdEnvironnement(?Environnement $idEnvironnement): static
    {
        $this->idEnvironnement = $idEnvironnement;

        return $this;
    }

    public function getIdTypeConstruction(): ?TypeConstruction
    {
        return $this->idTypeConstruction;
    }

    public function setIdTypeConstruction(?TypeConstruction $idTypeConstruction): static
    {
        $this->idTypeConstruction = $idTypeConstruction;

        return $this;
    }
  
    
    public function addResponsableDemande(ResponsableDemande $responsableDemande): static
    {
        if (!$this->responsableDemandes->contains($responsableDemande)) {
            $this->responsableDemandes[] = $responsableDemande;
            $responsableDemande->setIdMaDemande($this);
        }
    
        return $this;
    }
    
    public function removeResponsableDemande(ResponsableDemande $responsableDemande): static
    {
        if ($this->responsableDemandes->removeElement($responsableDemande)) {
            // Set the owning side to null (unless already changed)
            if ($responsableDemande->getIdMaDemande() === $this) {
                $responsableDemande->setIdMaDemande(null);
            }
        }
    
        return $this;
    }
    
    public function getResponsableDemandes(): Collection
    {
        return $this->responsableDemandes;
    }
  
}
