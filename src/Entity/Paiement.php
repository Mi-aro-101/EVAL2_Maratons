<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{

    public function handleDatasThenPersist(Devis $devis, SessionInterface $session, ClientRepository $clientRepository, EntityManagerInterface $entityManager)
    {
        $user = $session->get('PHPSESSID');
        $user = $clientRepository->find($user->getId());
        $this->setDevis($devis);
        $this->setClient($user);

        $entityManager->persist($this);
        $entityManager->flush();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2)]
    private ?string $montant = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePaiement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Devis $devis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(\DateTimeInterface $datePaiement): static
    {
        $this->datePaiement = $datePaiement;

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

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): static
    {
        $this->devis = $devis;

        return $this;
    }
}
