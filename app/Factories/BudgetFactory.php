<?php

namespace App\Factories;

class BudgetFactory extends BaseFactory
{
    protected function generateFactoryItem(array $accounts = []): array
    {
        return [
            'id' => fake()->uuid(),
            'name' => fake()->word(2, true),
            'last_modified' => fake()->date('Y-m-d H:i:s', true),
            'first_month' => fake()->date('Y-m-d'),
            'last_month' => fake()->date('Y-m-d'),
            'date_format' => [
                'format' => ''
            ],
            'currency_format' => [
                'iso_code' => '',
                'example_format' => '',
                'decimal_digits' => 1073741824,
                'decimal_separator' => '.',
                'symbol_first' => true,
                'group_separator' => ',',
                'currency_symbol' => '$',
                'display_symbol' => true,
            ],
            'accounts' => $accounts,
        ];
    }
}
