<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use App\Repository\TypeMaisonRepository;
use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{

    public function getPaimentEffectues(): float
    {
        $result = 0;

        foreach($this->getPaiements() as $paiements){
            $result += $paiements->getMontant();
        }

        return $result;
    }

    public function handleDatasThenPersist(Request $request, TypeMaisonRepository $typeMaisonRepository, EntityManagerInterface $entityManager)
    {
        $maison_id = $request->request->get('maison');
        $maison = $typeMaisonRepository->find($maison_id);
        $prixDevis = $this->calculerPrixDevis($maison->getPrixTotal(), $this->getTypeFinition()->getPourcentage());
        $dateFin = clone $this->getDateDebutTravaux();
        $dateFin = $dateFin->add(DateInterval::createFromDateString($maison->getDureeConstruction(). 'day'));
        $this->setDatefin($dateFin);
        // new devisDetails
        foreach($maison->getTravauxMaisons() as $travauxMaison){
            $devisDetails = new DevisDetails();
            $devisDetails->setPourcentageFinition($this->getTypeFinition()->getPourcentage());
            $devisDetails->setQuantiteTravaux($travauxMaison->getQuantite());
            $devisDetails->setPrixUnitaire($travauxMaison->getTravaux()->getPrixUnitaire());
            $devisDetails->setDesignationTravaux($travauxMaison->getTravaux()->getDescription());
            $this->addDevisDetail($devisDetails);
        }
        // setting datas
        $this->setTypeMaison($maison);
        $this->setPrix($prixDevis);
        // Flushing to the database
        $entityManager->persist($this);
        $entityManager->flush();
    }

    public function calculerPrixDevis($prixMaison, $pourcentageFinition) : float
    {
        $result = 0;
        $prixFinition = ($pourcentageFinition*$prixMaison)/100;
        $result = $prixFinition + $prixMaison;
        return $result;
    }

    public function getTypeFinitionValeur() : float
    {
        $result = 0;
        $result = ($this->getTypeMaison()->getPrixTotal() * $this->getTypeFinition()->getPourcentage())/100;

        return $result;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDevis = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeMaison $typeMaison = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeFinition $typeFinition = null;

    /**
     * @var Collection<int, DevisDetails>
     */
    #[ORM\OneToMany(targetEntity: DevisDetails::class, mappedBy: 'devis', cascade: ['persist'])]
    private Collection $devisDetails;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebutTravaux = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    private ?float $pourcentagePaye = null;

    /**
     * @var Collection<int, Paiement>
     */
    #[ORM\OneToMany(targetEntity: Paiement::class, mappedBy: 'devis', orphanRemoval: true)]
    private Collection $paiements;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datefin = null;

    public function __construct()
    {
        $this->devisDetails = new ArrayCollection();
        $this->paiements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateDevis(): ?\DateTimeInterface
    {
        return $this->dateDevis;
    }

    public function setDateDevis(\DateTimeInterface $dateDevis): static
    {
        $this->dateDevis = $dateDevis;

        return $this;
    }

    public function getTypeMaison(): ?TypeMaison
    {
        return $this->typeMaison;
    }

    public function setTypeMaison(?TypeMaison $typeMaison): static
    {
        $this->typeMaison = $typeMaison;

        return $this;
    }

    public function getTypeFinition(): ?TypeFinition
    {
        return $this->typeFinition;
    }

    public function setTypeFinition(?TypeFinition $typeFinition): static
    {
        $this->typeFinition = $typeFinition;

        return $this;
    }

    /**
     * @return Collection<int, DevisDetails>
     */
    public function getDevisDetails(): Collection
    {
        return $this->devisDetails;
    }

    public function addDevisDetail(DevisDetails $devisDetail): static
    {
        if (!$this->devisDetails->contains($devisDetail)) {
            $this->devisDetails->add($devisDetail);
            $devisDetail->setDevis($this);
        }

        return $this;
    }

    public function removeDevisDetail(DevisDetails $devisDetail): static
    {
        if ($this->devisDetails->removeElement($devisDetail)) {
            // set the owning side to null (unless already changed)
            if ($devisDetail->getDevis() === $this) {
                $devisDetail->setDevis(null);
            }
        }

        return $this;
    }

    public function getDateDebutTravaux(): ?\DateTimeInterface
    {
        return $this->dateDebutTravaux;
    }

    public function setDateDebutTravaux(\DateTimeInterface $dateDebutTravaux): static
    {
        $this->dateDebutTravaux = $dateDebutTravaux;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Paiement>
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): static
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setDevis($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): static
    {
        if ($this->paiements->removeElement($paiement)) {
            // set the owning side to null (unless already changed)
            if ($paiement->getDevis() === $this) {
                $paiement->setDevis(null);
            }
        }

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): static
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getpourcentagePaye(): ?float
    {
        return $this->pourcentagePaye;
    }

    public function setPourcentagePaye(float $pourcentagePaye): static
    {
        $this->pourcentagePaye = $pourcentagePaye;

        return $this;
    }
}
