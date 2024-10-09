<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'lesTransactions')]
    private ?Portefeuille $lePortefeuille = null;

    #[ORM\ManyToOne(inversedBy: 'lesTransactions')]
    private ?Action $laAction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getLePortefeuille(): ?Portefeuille
    {
        return $this->lePortefeuille;
    }

    public function setLePortefeuille(?Portefeuille $lePortefeuille): static
    {
        $this->lePortefeuille = $lePortefeuille;

        return $this;
    }

    public function getLaAction(): ?Action
    {
        return $this->laAction;
    }

    public function setLaAction(?Action $laAction): static
    {
        $this->laAction = $laAction;

        return $this;
    }

    public function calculerValeurTransaction(): ?float {
        $quantite = $this->getQuantite();
        $prix = $this->getPrix();

        $valeur = $quantite * $prix;

        return $valeur;
    }
}
