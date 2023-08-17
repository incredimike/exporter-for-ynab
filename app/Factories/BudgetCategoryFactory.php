<?php

namespace App\Factories;

class BudgetCategoryFactory extends BaseFactory
{
    protected function generateFactoryItem(): array
    {
        return [
            'id' => fake()->uuid(),
            'name' => fake()->word(2, true),
            'transfer_account_id' => fake()->word(2, true),
            'deleted' => fake()->boolean(),
        ];
    }
}
