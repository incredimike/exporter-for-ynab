<?php

namespace Tests\Unit;

use App\Budget\ExportCriteria;
use App\Enums\TransactionClearedStatusEnum;
use App\Enums\TransactionFlagColorEnum;
use App\Factories\TransactionCollectionFactory;
use App\Budget\Services\YnabBudgetExportService;
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

        $exporter = new YnabBudgetExportService();
        $exporter->setToken(fake()->word());

        $criteria = new ExportCriteria();
        $criteria->setStartDate($start_date);

        $exporter->setExportCriteria($criteria);
        $response = $exporter->execute();

        $this->assertCount($count, $response);
        $this->assertEquals($start_date, $response[0]['date']);
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

    protected function generateSubTransactions(int $total): array
    {
        $count = fake()->biasedNumberBetween(2, 5, 'cos');
        $amounts = array_map(
            static fn ($amount) => $amount * 10,
            $this->generateSubTransactionValues($total / 10, $count)
        ); // @todo this math does not seem to do an accurate split

        $transactions = [];
        for ($i = 0; $i < $count; $i++) {
            $transactions[] = [
                'id' => fake()->uuid(),
                "transaction_id" => fake()->uuid(),
                "amount" => $amounts[$i],
                "memo" => fake()->words(5, true),
                "payee_id" => fake()->uuid(),
                "payee_name" => fake()->words(3, true),
                "category_id" => fake()->uuid(),
                "category_name" => fake()->words(3, true),
                "transfer_account_id" => fake()->randomElement([fake()->uuid(), null]),
                "transfer_transaction_id" => fake()->randomElement([fake()->uuid(), null]),
                "deleted" => fake()->boolean(),
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

    protected function generateTransaction(string $start_date): array
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
                [], [], [] // hacky 1 in 4 chance generateSubTransactions() will run
            ])
        ];
    }
}
