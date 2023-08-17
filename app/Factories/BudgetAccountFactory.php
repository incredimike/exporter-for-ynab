<?php

namespace App\Factories;

class BudgetAccountFactory extends BaseFactory
{
    protected function generateFactoryItem(): array
    {
        $balance = fake()->randomNumber(8, true);

        return [
            'id' => fake()->uuid(),
            'name' => fake()->word(2, true),
            'type' => fake()->randomElement(['checking', 'savings']),

            'on_budget' => fake()->boolean(),
            'closed' => fake()->boolean(),
            'note' => fake()->word(2, true),

            'balance' => $balance,
            'cleared_balance' => $balance,
            'uncleared_balance' => $balance,

            'transfer_payee_id' => fake()->uuid(),

            'direct_import_linked' => fake()->boolean(),
            'direct_import_in_error' => fake()->boolean(),

            'last_reconciled_at' => fake()->date('Y-m-d H:i:s'),
            'debt_original_balance' => $balance,
            'debt_interest_rates' => [
                'additionalProp1' => $balance,
                'additionalProp2' => $balance,
                'additionalProp3' => $balance,
            ],
            'debt_minimum_payments' => [
                'additionalProp1' => $balance,
                'additionalProp2' => $balance,
                'additionalProp3' => $balance,
            ],
            'debt_escrow_amounts' => [
                'additionalProp1' => $balance,
                'additionalProp2' => $balance,
                'additionalProp3' => $balance,
            ],
            'deleted' => fake()->boolean(),
        ];
    }
}
