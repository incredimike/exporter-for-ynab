<?php

namespace App\Budget;

use App\DTOs\TransactionDTO;
use Illuminate\Support\Collection;

class TransactionCollection
{
    private Collection $transactions;

    public function __construct(array $transactions)
    {
        $this->transactions = collect($transactions);
    }
    public function flatten(): TransactionCollection
    {
        [$transactions, $hasSubtransactions] = $this->transactions->partition(
            fn(array $transaction) => empty($transaction['subtransactions'])
        );
        $transactions->transform(function ($transaction) {
            unset($transaction['subtransactions']);
            return $transaction;
        });
        $hasSubtransactions->each(function ($transaction) use ($transactions) {
            foreach ($transaction['subtransactions'] as $sub) {
                $new = [...$transaction, ...$sub];
                $new['parent_id'] = $transaction['id'];
                unset($new['subtransactions']);
                $transactions->add($new);
            }
        });
        $this->transactions = $transactions;
        return $this;
    }

    public function getTransations(): Collection
    {
        return $this->transactions;
    }
}
