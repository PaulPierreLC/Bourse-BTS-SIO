<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $symbole = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEntreprise = null;

    #[ORM\Column]
    private ?float $prix = null;

    /**
     * @var Collection<int, Portefeuille>
     */
    #[ORM\ManyToMany(targetEntity: Portefeuille::class, mappedBy: 'lesActions')]
    private Collection $lesPortefeuilles;

    /**
     * @var Collection<int, transaction>
     */
    #[ORM\OneToMany(targetEntity: transaction::class, mappedBy: 'laAction')]
    private Collection $lesTransactions;

    public function __construct()
    {
        $this->lesPortefeuilles = new ArrayCollection();
        $this->lesTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbole(): ?string
    {
        return $this->symbole;
    }

    public function setSymbole(string $symbole): static
    {
        $this->symbole = $symbole;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;

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

    /**
     * @return Collection<int, Portefeuille>
     */
    public function getLesPortefeuilles(): Collection
    {
        return $this->lesPortefeuilles;
    }

    public function addLesPortefeuille(Portefeuille $lesPortefeuille): static
    {
        if (!$this->lesPortefeuilles->contains($lesPortefeuille)) {
            $this->lesPortefeuilles->add($lesPortefeuille);
            $lesPortefeuille->addLesAction($this);
        }

        return $this;
    }

    public function removeLesPortefeuille(Portefeuille $lesPortefeuille): static
    {
        if ($this->lesPortefeuilles->removeElement($lesPortefeuille)) {
            $lesPortefeuille->removeLesAction($this);
        }

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
            $lesTransaction->setLaAction($this);
        }

        return $this;
    }

    public function removeLesTransaction(transaction $lesTransaction): static
    {
        if ($this->lesTransactions->removeElement($lesTransaction)) {
            // set the owning side to null (unless already changed)
            if ($lesTransaction->getLaAction() === $this) {
                $lesTransaction->setLaAction(null);
            }
        }

        return $this;
    }

    public function calculerQuantiteTotaleDansPortefeuilles(): int {
        $quantiteTotale = 0;
        
        $portefeuilles = $this->getLesPortefeuilles();
        
        foreach ($portefeuilles as $portefeuille) { 
            $transactions = $portefeuille->getLesTransactions();

            foreach ($transactions as $transaction) {
                if ($transaction->getLaAction() === $this) {
                    $quantite = $transaction->getQuantite();
                    
                    switch ($transaction->getType()) {
                        case "Achat":
                            $quantiteTotale += $quantite;
                            break;
                        case "Vente":
                            $quantiteTotale -= $quantite;
                            break;
                    }
                }
            }
        }
        
        return $quantiteTotale;
    }

    public function obtenirSymbole(): string {
        return $this->symbole;
    }

    public function obtenirNomEntreprise(): string {
        return $this->nomEntreprise;
    }

    public function listerPortefeuillesDetenantAction(): array {
        $PortefeuillesDetenantAction = [];
        
        $portefeuilles = $this->lesPortefeuilles;

        foreach ($portefeuilles as $portefeuille) {
            $PortefeuillesDetenantAction[] = $portefeuille->getNom();
        }

        return $PortefeuillesDetenantAction;
    }
    
    public function afficherHistoriqueTransactions(): ?array
    {   
        $HistoriqueTransactions = [];
        $transactions = $this->lesTransactions;

        foreach ($transactions as $transaction)
        {
            $HistoriqueTransaction["date"] = $transaction->getDate();
            $HistoriqueTransaction["type"] = $transaction->getType();
            $HistoriqueTransaction["date"] = $transaction->getDate();
            $HistoriqueTransaction["date"] = $transaction->getDate();   
        }

        return $HistoriqueTransactions; 
    }

    public function estActionRentable(): bool
    {
        $actionRentable = False;

        return $actionRentable;
    }

}
