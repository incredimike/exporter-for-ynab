<?php

namespace Tests\Unit;

use App\Budget\ExportCriteria;
use App\Budget\TransactionCollection;
use App\Budget\TransactionExporter;
use App\Factories\TransactionCollectionFactory;
use App\Repositories\YnabBudgetRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FetchTransactionsTest extends TestCase
{
    use WithFaker;

    private TransactionCollectionFactory $transaction_factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->transaction_factory = $this->app->make(TransactionCollectionFactory::class);
    }

    public function testCanFetchTransactions(): void
    {
        $count = 10;
        $start_date = '2023-01-01';

        Http::fake([
            'https://api.ynab.com/v1/*' => Http::response($this->generateResponseArray($count, $start_date))
        ]);

        $repository = new YnabBudgetRepository();
        $repository->setToken(fake()->word());

        $criteria = new ExportCriteria();
        $criteria->setStartDate($start_date);

        $exporter = new TransactionExporter($repository, $criteria);
        $exporter->setToken(fake()->word()); // fix this double set token


        $response = $exporter->export();

        $this->assertSame($count, $response->getCollection()->count());
        $this->assertEquals($start_date, $response->getCollection()[0]['date']);
    }

    protected function generateResponseArray(int $count = 5, string $startDate = '-6 months'): array
    {
        $transactions = $this->transaction_factory
            ->count($count)
            ->startDate($startDate)
            ->make();

        return [
            'data' => [
                'transactions' => $transactions,
                'server_knowledge' => fake()->numberBetween(10000, 99999)
            ]
        ];
    }

}
