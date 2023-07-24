<?php

namespace App\Factories;

use App\Enums\TransactionClearedStatusEnum;
use App\Enums\TransactionFlagColorEnum;

class TransactionCollectionFactory
{
    protected int $count = 5;
    protected string $startDate = '-6 months';

    public function make()
    {
        $transactions = [];
        for ($i=0; $i < $this->count; $i++) {
            $transactions[] = $this->generateTransaction( $this->startDate );
        }
        return $transactions;
    }

    public function count($count): self
    {
        $this->count = $count;
        return $this;
    }

    public function startDate(string $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
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
                array()
            ])
        ];
    }

    protected function generateSubTransactions(int $total): array
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

}
