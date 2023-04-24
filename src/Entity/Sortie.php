<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateLimiteInscription = null;

    #[ORM\Column]
    private ?int $nbInscriptionsMax = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infosSortie = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?lieu $lieu = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?campus $campus = null;

    #[ORM\ManyToOne(inversedBy: 'sorties')]
    private ?etat $etat = null;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'sorties')]
    private Collection $organisateur;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'sorties')]
    private Collection $participants;

    public function __construct()
    {
        $this->organisateur = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nbInscriptionsMax;
    }

    public function setNbInscriptionsMax(int $nbInscriptionsMax): self
    {
        $this->nbInscriptionsMax = $nbInscriptionsMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getLieu(): ?lieu
    {
        return $this->lieu;
    }

    public function setLieu(?lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getCampus(): ?campus
    {
        return $this->campus;
    }

    public function setCampus(?campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getEtat(): ?etat
    {
        return $this->etat;
    }

    public function setEtat(?etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getOrganisateur(): Collection
    {
        return $this->organisateur;
    }

    public function addOrganisateur(user $organisateur): self
    {
        if (!$this->organisateur->contains($organisateur)) {
            $this->organisateur->add($organisateur);
            $organisateur->setSorties($this);
        }

        return $this;
    }

    public function removeOrganisateur(user $organisateur): self
    {
        if ($this->organisateur->removeElement($organisateur)) {
            // set the owning side to null (unless already changed)
            if ($organisateur->getSorties() === $this) {
                $organisateur->setSorties(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(user $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(user $participant): self
    {
        $this->participants->removeElement($participant);

        return $this;
    }
}
