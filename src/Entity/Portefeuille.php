<?php

namespace App\Entity;

use App\Repository\PortefeuilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortefeuilleRepository::class)]
class Portefeuille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'lesPortefeuilles')]
    private ?Trader $leTrader = null;

    /**
     * @var Collection<int, action>
     */
    #[ORM\ManyToMany(targetEntity: action::class, inversedBy: 'lesPortefeuilles')]
    private Collection $lesActions;

    /**
     * @var Collection<int, transaction>
     */
    #[ORM\OneToMany(targetEntity: transaction::class, mappedBy: 'lePortefeuille')]
    private Collection $lesTransactions;

    public function __construct()
    {
        $this->lesActions = new ArrayCollection();
        $this->lesTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLeTrader(): ?Trader
    {
        return $this->leTrader;
    }

    public function setLeTrader(?Trader $leTrader): static
    {
        $this->leTrader = $leTrader;

        return $this;
    }

    /**
     * @return Collection<int, action>
     */
    public function getLesActions(): Collection
    {
        return $this->lesActions;
    }

    public function addLesAction(action $lesAction): static
    {
        if (!$this->lesActions->contains($lesAction)) {
            $this->lesActions->add($lesAction);
        }

        return $this;
    }

    public function removeLesAction(action $lesAction): static
    {
        $this->lesActions->removeElement($lesAction);

        return $this;
    }

    /**
     * @return Collection<int, transaction>
     */
    public function getLesTransactions(): Collection
    {
        return $this->lesTransactions;
    }

    public function addLesTransaction(transaction $lesTransaction): static
    {
        if (!$this->lesTransactions->contains($lesTransaction)) {
            $this->lesTransactions->add($lesTransaction);
            $lesTransaction->setLePortefeuille($this);
        }

        return $this;
    }

    public function removeLesTransaction(transaction $lesTransaction): static
    {
        if ($this->lesTransactions->removeElement($lesTransaction)) {
            // set the owning side to null (unless already changed)
            if ($lesTransaction->getLePortefeuille() === $this) {
                $lesTransaction->setLePortefeuille(null);
            }
        }

        return $this;
    }

    public function calculerValeurPortefeuille(): ?float {
        $valeurTotale = 0;
        $actions = $this->getLesActions();
        
        foreach ($actions as $action) {
            $transactions = $action->getLesTransactions();
            $prixActuel = $action->getPrix();
            $quantiteAction = 0;

            foreach ($transactions as $transaction) {
                if ($transaction->getLePortefeuille() === $this) {
                    $quantite = $transaction->getQuantite();
                    
                    switch ($transaction->getType()) {
                        case "Achat":
                            $quantiteAction += $quantite;
                            break;
                        case "Vente":
                            $quantiteAction -= $quantite;
                            break;
                    }
                }
            }

            $valeurTotale += $quantiteAction * $prixActuel;
        }
        
        return $valeurTotale;
    }

    public function obtenirSymbolesActions(): ?array
    {
        $symbolesActions = [];
        $actions = $this->lesActions;

        foreach ($actions as $symbole => $details) {
            $symbolesActions[] = $symbole;
        }

        return $symbolesActions;
    }

    public function calculerValeurPortefeuillev2(): float 
    {
        $valeurPortefeuille = 0;
        $transactions = $this->lesTransactions;

        foreach ($transactions as $transaction) {
            $prixAction = $transaction->getLaAction()->getPrix();
            $typeTransaction = $transaction->getType();
            $quantiteTransaction = $transaction->getQuantite();
            
            if ($typeTransaction === "Achat") {
                $valeurPortefeuille += $prixAction * $quantiteTransaction;
            }
            else if ($typeTransaction === "Vente") {
                $valeurPortefeuille -= $prixAction * $quantiteTransaction;
            }
        }
        

        return $valeurPortefeuille;
    }

    public function filtrerTransactionsParDate(\DateTimeInterface $dateDebut, \DateTimeInterface $dateFin): array
    {
        $transactionsParDate = [];
        $transactions = $this->lesTransactions;
        
        foreach ($transactions as $transaction) {
            $dateTransaction = $transaction->getDate();

            if (($dateTransaction > $dateDebut) & ($dateTransaction < $dateFin)) {
                $transactionsParDate[] = $transaction;
            }
        }

        return $transactionsParDate;
    }
}
