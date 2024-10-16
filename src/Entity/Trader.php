<?php

namespace App\Entity;

use App\Repository\TraderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraderRepository::class)]
class Trader
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, portefeuille>
     */
    #[ORM\OneToMany(targetEntity: portefeuille::class, mappedBy: 'leTrader')]
    private Collection $lesPortefeuilles;

    public function __construct()
    {
        $this->lesPortefeuilles = new ArrayCollection();
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

    /**
     * @return Collection<int, portefeuille>
     */
    public function getLesPortefeuilles(): Collection
    {
        return $this->lesPortefeuilles;
    }

    public function addLesPortefeuille(portefeuille $lesPortefeuille): static
    {
        if (!$this->lesPortefeuilles->contains($lesPortefeuille)) {
            $this->lesPortefeuilles->add($lesPortefeuille);
            $lesPortefeuille->setLeTrader($this);
        }

        return $this;
    }

    public function removeLesPortefeuille(portefeuille $lesPortefeuille): static
    {
        if ($this->lesPortefeuilles->removeElement($lesPortefeuille)) {
            // set the owning side to null (unless already changed)
            if ($lesPortefeuille->getLeTrader() === $this) {
                $lesPortefeuille->setLeTrader(null);
            }
        }

        return $this;
    }

    public function calculerValeurTotalePortefeuilles(): ?float {
        $valeurTotale = 0; 
        $portefeuilles = $this->getLesPortefeuilles();

        foreach ($portefeuilles as $portefeuille) { 
            $valeurPortefeuille = $portefeuille->calculerValeurPortefeuille();
            $valeurTotale += $valeurPortefeuille;
        }

        return $valeurTotale;
    }

    public function obtenirNomTrader(): ?string {
        return $this->nom;
    }

    public function obtenirNomsPortefeuilles(): ?array
    {
        $NomsPortefeuilles = [];
        $portefeuilles = $this->lesPortefeuilles;

        foreach ($portefeuilles as $portefeuille) {
            $NomsPortefeuilles[] = $portefeuille->getNom();
        }

        return $NomsPortefeuilles;
    }
    public function compterNombreTotalActions(): ?int
    {
        $NombreTotalActions = 0;
        $portefeuilles = $this->lesPortefeuilles;

        foreach ($portefeuilles as $portefeuille) {
            $actions = $portefeuille->getLesActions();

            foreach ($actions as $action) {
                $NombreTotalActions++;
            }
        }

        return $NombreTotalActions;
    }

    public function afficherTransactionsTrader(): void {
        $portefeuilles = $this->lesPortefeuilles;

        echo "Transactions du Trader: ".$this->getNom();

        foreach ($portefeuilles as $portefeuille) {
            $transactions = $portefeuille->getLesTransactions();

            echo "Portefeuille: ".$portefeuille->getNom();
            
            foreach ($transactions as $transaction) {
                echo "Date: ".$transaction->getDate();
                echo "Action: ".$transaction->getLaAction()->getSymbole();
                echo "Quantité: ".$transaction->getQuantite();
                echo "Prix: ".$transaction->getPrix();
            }
        }
    }

    public function calculerProfitTotal(): float
    {
        $portefeuilles = $this->lesPortefeuilles;


        foreach ($portefeuilles as $portefeuille) {
            $transactions = $portefeuille->getLesTransactions();

            
            foreach ($transactions as $transaction) {
                
            }
    }
}
