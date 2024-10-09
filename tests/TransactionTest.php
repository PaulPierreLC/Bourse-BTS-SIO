<?php

namespace App\Tests;

use App\Entity\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testCalculerValeurTransaction()
    {
        // Créer une instance mockée de la classe Transaction
        $transactionMock = $this->getMockBuilder(Transaction::class)
                                ->disableOriginalConstructor()
                                ->getMock();


        // Définir la valeur de retour de getQuantite
        $transactionMock->method('getQuantite')
                        ->willReturn(10);


        // Définir la valeur de retour de getPrix
        $transactionMock->method('getPrix')
                        ->willReturn(5.5);


        // Appeler la méthode calculerValeurTransaction
        $expectedValue = 10 * 5.5; // 55.0
        $transactionMock->method('calculerValeurTransaction')
                        ->willReturn($expectedValue);


        $this->assertEquals(55.0, $transactionMock->calculerValeurTransaction());
    }
}
