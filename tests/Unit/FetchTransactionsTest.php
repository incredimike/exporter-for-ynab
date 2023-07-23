<?php

namespace Tests\Unit;

use App\Enums\TransactionClearedStatusEnum;
use App\Enums\TransactionFlagColorEnum;
use App\Services\YnabBudgetExportService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FetchTransactionsTest extends TestCase
{
    use WithFaker;

    public function test_can_fetch_transactions(): void
    {
        $count = 10;
        $start_date = '2023-01-01';

        Http::fake([
            'https://api.ynab.com/v1/*' => Http::response($this->generateResponseArray($count, $start_date))
        ]);

        // set search criteria
        $token = fake()->word();
        $exporter = new YnabBudgetExportService();
        $exporter->setToken($token);
        $exporter->setStartDate($start_date);
        $exporter->setBudgetId('last-used');

        $response = $exporter->execute();

        $this->assertCount($count, $response);
        $this->assertEquals($start_date, $response[0]['date']);
    }

    protected function generateResponseArray(int $count = 5, string $start_date = '-6 months'): array
    {
        $response = [
            'data' => [
                'transactions' => [],
                'server_knowledge' => fake()->numberBetween(10000, 99999)
            ]
        ];
        for ($i=0; $i < $count; $i++) {
            $response['data']['transactions'][] = $this->generateTransaction( $start_date );
        }
        return $response;
    }

    protected function generateSubTransactions( int $total ): array
    {
        $count = fake()->numberBetween(2, 4);
        $amounts = array_map(
            static fn ($amount) => $amount*10,
            $this->generateSubTransactionValues($total/10, $count)
        ); // close enough for now.

        $transactions = [];
        for($i = 0; $i < $count; $i++) {
            $transactions[] = [
                'id'=> fake()->uuid(),
                "transaction_id" => fake()->uuid(),
                "amount" => $amounts[$i],
                "memo" => fake()->words(5, true),
                "payee_id" => fake()->uuid(),
                "payee_name" => fake()->words(3, true),
                "category_id" => fake()->uuid(),
                "category_name" => fake()->words(3, true),
                "transfer_account_id" => fake()->randomElement([fake()->uuid(), null]),
                "transfer_transaction_id" => fake()->randomElement([fake()->uuid(), null]),
                "deleted"=> fake()->boolean(),
            ];
        }
        return $transactions;
    }

    protected function generateSubTransactionValues($total, $count): array
    {
            if ($count <= 0 || $total <= 0) {
                return [];
            }

            $result = [];
            $remainingCount = $count;

            // Loop until the total is reduced to zero or we've filled the array
            while ($total > 0 && $remainingCount > 0) {
                // Generate a random integer between 1 and the total (inclusive)
                /** @noinspection RandomApiMigrationInspection */
                $value = rand(1, $total);

                // If the generated value is greater than the remaining total,
                // set it to the remaining total to avoid going over the target amount
                if ($value > $total) {
                    $value = $total;
                }

                // Add the value to the result array
                $result[] = $value;

                // Update the total and remaining count
                $total -= $value;
                $remainingCount--;
            }

            // If there are still remaining slots in the array,
            // fill them with zeros to make sure the array has the desired count
            while ($remainingCount > 0) {
                $result[] = 0;
                $remainingCount--;
            }

            return $result;
        }

    protected function generateTransaction( string $start_date )
    {
        $amount = fake()->numberBetween(1000, 80000) * 10;
        $date = fake()->dateTimeInInterval($start_date, '+12 hours');

        return [
            'id' => fake()->uuid(),
            'date' => $date->format('Y-m-d'),
            'amount' => $amount,
            'memo' => fake()->randomElement([
                fake()->words(5, true),
                null
            ]),
            'cleared' => fake()->randomElement(TransactionClearedStatusEnum::cases())->value,
            'approved' => fake()->boolean(),
            'flag_color' => fake()->randomElement(TransactionFlagColorEnum::cases())->value,
            'account_id' => fake()->uuid(),
            'account_name' => fake()->words(2, true),
            'payee_id' => fake()->uuid(),
            'payee_name' => fake()->words(2, true),
            'category_id' => fake()->randomElement([fake()->uuid(), null]),
            'category_name' => fake()->randomElement(
                array_merge(
                    fake()->words(4),
                    ['Uncategorized']
                )
            ),
            'transfer_account_id' => null,
            'transfer_transaction_id' => null,
            'matched_transaction_id' => null,
            'import_id' => null,
            'import_payee_name' => null,
            'import_payee_name_original' => null,
            'debt_transaction_type' => null,
            'deleted' => fake()->boolean(),
            'subtransactions' => fake()->randomElement([
                $this->generateSubTransactions($amount),
                array()
            ])
        ];
    }
}
