<?php
namespace App\Entity;

use App\Repository\ResponsableDemandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponsableDemandeRepository::class)]
class ResponsableDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $DRTM = null;

    #[ORM\Column]
    private ?bool $EDBM = null;

    #[ORM\Column]
    private ?bool $DAT = null;

    #[ORM\Column]
    private ?bool $DG = null;

    #[ORM\Column]
    private ?bool $SG = null;

    #[ORM\Column]
    private ?bool $Ministre = null;

    #[ORM\ManyToOne(inversedBy: 'responsableDemandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MaDemande $maDemande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isDRTM(): ?bool
    {
        return $this->DRTM;
    }

    public function setDRTM(bool $DRTM): static
    {
        $this->DRTM = $DRTM;
        return $this;
    }

    public function isEDBM(): ?bool
    {
        return $this->EDBM;
    }

    public function setEDBM(bool $EDBM): static
    {
        $this->EDBM = $EDBM;
        return $this;
    }

    public function isDAT(): ?bool
    {
        return $this->DAT;
    }

    public function setDAT(bool $DAT): static
    {
        $this->DAT = $DAT;
        return $this;
    }

    public function isDG(): ?bool
    {
        return $this->DG;
    }

    public function setDG(bool $DG): static
    {
        $this->DG = $DG;
        return $this;
    }

    public function isSG(): ?bool
    {
        return $this->SG;
    }

    public function setSG(bool $SG): static
    {
        $this->SG = $SG;
        return $this;
    }

    public function isMinistre(): ?bool
    {
        return $this->Ministre;
    }

    public function setMinistre(bool $Ministre): static
    {
        $this->Ministre = $Ministre;
        return $this;
    }

    public function getMaDemande(): ?MaDemande
    {
        return $this->maDemande;
    }

    public function setMaDemande(?MaDemande $maDemande): static
    {
        $this->maDemande = $maDemande;
        return $this;
    }
}
