<?php

namespace Tests\Feature;

use App\Factories\TransactionCollectionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExportPreviewTest extends TestCase
{

    private TransactionCollectionFactory $transaction_factory;

    public function setUp(): void {
        parent::setUp();
        $this->transaction_factory = $this->app->make(TransactionCollectionFactory::class);
    }

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $count = 10;
        $startDate = '2023-01-01';

        Http::fake([
            'https://api.ynab.com/v1/*' => Http::response($this->generateResponseArray($count, $startDate))
        ]);

//        $response = $this->getJson('/export/preview?start_date='.$startDate);
        $response = $this->postJson('/export/preview', [
            'start_date' => $startDate
        ]);

        //dump($response->getContent());;
        //dd($response);
        //dd($response);

        // Populate the ExportCriteria object from $request
        // Create new BudgetExporter object with YnabApiService and Criteria object
        // Call export() method on the BudgetExporter object
        // Return a TransactionCollection with all transactions
        // Flatten subtranactions in TransactionCollection into an array of transactions.
        //
        //
        $response->assertStatus(200);
        $response->assertJson(function(AssertableJson $json) use ($count) {
            $json->hasAll(['success', 'data'])
                ->missing('message')
                ->has('data.transactions', $count);
        }
        );
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
