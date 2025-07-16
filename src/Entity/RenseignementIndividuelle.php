<?php
namespace App\Entity;

use App\Repository\RenseignementIndividuelleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenseignementIndividuelleRepository::class)]
class RenseignementIndividuelle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $individuNom = null;

    #[ORM\Column(length: 255)]
    private ?string $individuPrenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresseIndividu = null;

    #[ORM\Column(length: 255)]
    private ?string $mailIndividu = null;

    #[ORM\Column(length: 20)]
    #[Assert\Length(
        min: 10,
        max: 20,
        minMessage: 'Le numéro de téléphone doit comporter au moins {{ limit }} chiffres.',
        maxMessage: 'Le numéro de téléphone ne peut pas comporter plus de {{ limit }} chiffres.'
    )]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: 'Le numéro de téléphone ne doit contenir que des chiffres.'
    )]
    private ?string $phoneIndividu = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'renseignementsIndividuels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Nationalite::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Nationalite $nationalite = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $error = null;

    /**
     * @var Collection<int, MaDemande>
     */
    #[ORM\OneToMany(targetEntity: MaDemande::class, mappedBy: 'idResneignementIndividuelle')]
    private Collection $maDemandes;

    public function __construct()
    {
        $this->maDemandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIndividuNom(): ?string
    {
        return $this->individuNom;
    }

    public function setIndividuNom(string $individuNom): static
    {
        $this->individuNom = $individuNom;
        return $this;
    }

    public function getIndividuPrenom(): ?string
    {
        return $this->individuPrenom;
    }

    public function setIndividuPrenom(string $individuPrenom): static
    {
        $this->individuPrenom = $individuPrenom;
        return $this;
    }

    public function getAdresseIndividu(): ?string
    {
        return $this->adresseIndividu;
    }

    public function setAdresseIndividu(string $adresseIndividu): static
    {
        $this->adresseIndividu = $adresseIndividu;
        return $this;
    }

    public function getMailIndividu(): ?string
    {
        return $this->mailIndividu;
    }

    public function setMailIndividu(string $mailIndividu): static
    {
        $this->mailIndividu = $mailIndividu;
        return $this;
    }

    public function getPhoneIndividu(): ?string
    {
        return $this->phoneIndividu;
    }

    public function setPhoneIndividu(string $phoneIndividu): static
    {
        $this->phoneIndividu = $phoneIndividu;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getNationalite(): ?Nationalite
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): static
    {
        $this->nationalite = $nationalite;
        return $this;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(?string $error): static
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return Collection<int, MaDemande>
     */
    public function getMaDemandes(): Collection
    {
        return $this->maDemandes;
    }

    public function addMaDemande(MaDemande $maDemande): static
    {
        if (!$this->maDemandes->contains($maDemande)) {
            $this->maDemandes->add($maDemande);
            $maDemande->setIdResneignementIndividuelle($this);
        }

        return $this;
    }

    public function removeMaDemande(MaDemande $maDemande): static
    {
        if ($this->maDemandes->removeElement($maDemande)) {
            // set the owning side to null (unless already changed)
            if ($maDemande->getIdResneignementIndividuelle() === $this) {
                $maDemande->setIdResneignementIndividuelle(null);
            }
        }

        return $this;
    }
}
