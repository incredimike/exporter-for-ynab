<?php

namespace Tests\Feature;

use App\Factories\TransactionCollectionFactory;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExportPreviewTest extends TestCase
{
    private TransactionCollectionFactory $transaction_factory;

    public function setUp(): void
    {
        parent::setUp();
        $this->transaction_factory = $this->app->make(TransactionCollectionFactory::class);
    }

    /**
     * A basic feature test example.
     */
    public function testSimplePreviewRequestReturnsData(): void
    {
        $startDate = '2023-01-01';
        $responseArray = [
            'data' => [
                'transactions' => $this->transaction_factory
                    ->count(fake()->numberBetween(10, 30))
                    ->startDate($startDate)
                    ->make(),
                'server_knowledge' => fake()->numberBetween(10000, 99999)
            ]
        ];
        Http::fake([
            '*' => Http::response($responseArray)
        ]);

        $response = $this->postJson('/export/preview', [
            'start_date' => $startDate
        ]);

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'data'])
                ->missing('message')
                ->has('data.transactions');
        });
    }
}
