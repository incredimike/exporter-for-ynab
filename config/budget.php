<?php

return [

    'ynab_api_key' => env('YNAB_API_TOKEN', ''),

    /*
     * Columns that may be sorted.
     */
    'sortable_columns' => [
        'account_name',
        'amount',
        'approved',
        'category_name',
        'cleared',
        'date',
        'flag_color',
        'memo',
        'payee_name',
    ],
    'filterable_columns' => [
        'account_name',
        'amount',
        'approved',
        'category_name',
        'cleared',
        'date',
        'flag_color',
        'memo',
        'payee_name',
    ]
];
