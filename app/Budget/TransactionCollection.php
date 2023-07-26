<?php

namespace App\Budget;

use Illuminate\Support\Collection;

class TransactionCollection extends Collection
{
    public function __construct($items = [])
    {
        parent::__construct($items);
    }

    public function flattenTransactions(): TransactionCollection
    {
        [$transactions, $hasSubtransactions] = $this->partition(
            fn(array $transaction) => empty($transaction['subtransactions'])
        );

        $hasSubtransactions->each(function ($transaction) use ($transactions) {
            foreach ($transaction['subtransactions'] as $sub) {
                $new = [...$transaction, ...$sub];
                $new['parent_id'] = $transaction['id'];
                unset($new['subtransactions']);
                $transactions->add($new);
            }
        });

        return $transactions;
    }
}
