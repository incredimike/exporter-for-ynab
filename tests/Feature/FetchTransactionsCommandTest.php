<?php

namespace Tests\Feature;

use App\Factories\TransactionFactory;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FetchTransactionsCommandTest extends TestCase
{

    private TransactionFactory $transaction_factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->transaction_factory = $this->app->make(TransactionFactory::class);
    }


    /**
     * Test a console command.
     */
    public function test_console_command(): void
    {
        $startDate = '2023-01-01';
        $transactions = $this->transaction_factory
            ->count(fake()->numberBetween(10, 30))
            ->startDate($startDate)
            ->make();
        $responseArray = [
            'data' => [
                'transactions' => $transactions,
                'server_knowledge' => fake()->numberBetween(10000, 99999)
            ]
        ];
        Http::fake([
            '*' => Http::response($responseArray)
        ]);

        $this->artisan('transactions:fetch')->assertSuccessful();
    }
}
