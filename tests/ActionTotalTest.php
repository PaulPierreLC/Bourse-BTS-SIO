<?php

namespace App\Tests;

use App\Entity\Action;
use App\Entity\Portefeuille;
use App\Entity\Transaction;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ActionTotalTest extends TestCase
{
        public function testCalculerQuantiteTotaleDansPortefeuilles()
        {
            $actionMock = $this->getMockBuilder(Action::class)->disableOriginalConstructor()->getMock();

            $portefeuilleMock1 = $this->getMockBuilder(Portefeuille::class)->disableOriginalConstructor()->getMock();
            $portefeuilleMock2 = $this->getMockBuilder(Portefeuille::class)->disableOriginalConstructor()->getMock();

            $transactionMock1 = $this->getMockBuilder(Transaction::class)->disableOriginalConstructor()->getMock();
            $transactionMock2 = $this->getMockBuilder(Transaction::class)->disableOriginalConstructor()->getMock();
            $transactionMock3 = $this->getMockBuilder(Transaction::class)->disableOriginalConstructor()->getMock();
            $transactionMock4 = $this->getMockBuilder(Transaction::class)->disableOriginalConstructor()->getMock();
            $transactionMock5 = $this->getMockBuilder(Transaction::class)->disableOriginalConstructor()->getMock();

            $portefeuillesMock = new arrayCollection([$portefeuilleMock1, $portefeuilleMock2]);

            $actionMock->method('getLesPortefeuilles')->willReturn($portefeuillesMock);
            
            $transactionsMock1 = new arrayCollection([$transactionMock1, $transactionMock2]);
            $portefeuilleMock1->method('getLesTransactions')->willReturn($transactionsMock1);

            $transactionsMock2 = new arrayCollection([$transactionMock3, $transactionMock4, $transactionMock5]);
            $portefeuilleMock2->method('getLesTransactions')->willReturn($transactionsMock2);

            $transactionMock1->method('getType')->willReturn("Achat");
            $transactionMock1->method('getLaAction')->willReturn($actionMock);
            $transactionMock1->method('getQuantite')->willReturn(50);

            $transactionMock2->method('getType')->willReturn("Vente");
            $transactionMock2->method('getLaAction')->willReturn($actionMock);
            $transactionMock2->method('getQuantite')->willReturn(30);

            $transactionMock3->method('getType')->willReturn("Achat");
            $transactionMock3->method('getLaAction')->willReturn($actionMock);
            $transactionMock3->method('getQuantite')->willReturn(60);

            $transactionMock4->method('getType')->willReturn("Achat");
            $transactionMock4->method('getLaAction')->willReturn($actionMock);
            $transactionMock4->method('getQuantite')->willReturn(40);

            $transactionMock5->method('getType')->willReturn("Vente");
            $transactionMock5->method('getLaAction')->willReturn($actionMock);
            $transactionMock5->method('getQuantite')->willReturn(20);

            $this->assertEquals(100, $actionMock->calculerQuantiteTotaleDansPortefeuilles());
        }
}
