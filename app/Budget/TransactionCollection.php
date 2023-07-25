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
//        $subtransactions = $this->where('subtransactions', '!=', null)
//            ->each(function ($transaction) {
//                return []
//            });
        [$originals, $hasSubtransactions] = $this->partition(function (array $transaction) {
            return empty($transaction['subtransactions']);
        });

        $subtransactions = $hasSubtransactions->each(function ($transaction) use ($originals) {
            foreach ($transaction['subtransactions'] as $sub) {
                $originals->add([
                    ... $transaction, ...$sub
                ]);
            }
        });

        // @todo make this work correctly.

        return $originals;
    }
}
