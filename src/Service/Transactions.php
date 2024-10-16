<?php

namespace App\Service;

class Transactions {
    public function calculerTransactionsValeurAchats(array $transactions): float 
    {
        $TransactionsValeurAchats = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->getType() === "Achat") {
                $quantite = $transaction->getQuantite();
                $prix = $transaction->getPrix();

                $TransactionsValeurAchats += $quantite * $prix;
            }
        }   
    
        return $TransactionsValeurAchats;
    }

    public function calculerMoyennePrixVentes(array $transactions): float 
    {
        $moyennePrixVentes = 0;
        $compteurVente = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->getType() === "Vente") {
                $compteurVente++;
                $moyennePrixVentes += $transaction->getPrix();
            }
        }
        
        $moyennePrixVentes /= $compteurVente;

        return $moyennePrixVentes;
    }

    public function trouverTransactionQuantiteMax(array $transactions): static
    {
        $transactionQuantiteMax = null;
        $QuantiteMax = 0;

        foreach ($transactions as $transaction) {
            $quantite = $transaction->getQuantite();
            if ( $QuantiteMax < $quantite ) 
            {
                $QuantiteMax = $quantite;
                $transactionQuantiteMax = $transaction;
            }
        }
        
        return $transactionQuantiteMax;
    }

    public function calculerNombreTransactionsParType(array $transactions): array
    {
        $nombreTransactionsParType = [];

        foreach ($transactions as $transaction) {
            $type = $transaction->getType();
            
            if ( isset($nombreTransactionsParType[$type]) ) {
                $nombreTransactionsParType[$type] = 0;
            } 
            else {
                $nombreTransactionsParType[$type]++;
            }   
        }
        
        return $nombreTransactionsParType;
    }

    public function calculerValeurTotaleTransactions(array $transactions): array
    {
        $valeurTotaleTransactions = [];

        foreach ($transactions as $transaction) {
            $type = $transaction->getType();
            if ( isset($valeurTotaleTransactions[$type]) ) {
                $valeurTotaleTransactions[$type] = 0;
            } else {
                $valeurTotaleTransactions[$type] += $transaction->getPrix();
            }
        
        }
        
        return $valeurTotaleTransactions;
    }

    
}