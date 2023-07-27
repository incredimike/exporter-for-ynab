<?php

namespace Tests\Unit;

use App\Budget\TransactionCollection;
use App\DTOs\TransactionDTO;
use App\Factories\TransactionCollectionFactory;
use Tests\TestCase;

class TransactionCollectionTest extends TestCase
{
    private $transaction_factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->transaction_factory = $this->app->make(TransactionCollectionFactory::class);
    }

    public function testCanCreateCollection(): void
    {
        $count = 5;
        $startDate = '2023-01-01';

        $transactions = $this->transaction_factory
            ->count($count)
            ->startDate($startDate)
            ->make();

        $transactions = new TransactionCollection($transactions);
        $this->assertCount($count, $transactions->getTransations()->toArray());
        //$this->assertInstanceOf(TransactionCollection::class, $transactions);
        //$this->assertInstanceOf(TransactionDTO::class, $transactions->first());
    }
}
