<?php

namespace App\Budget\Transactions\Specification;

use App\DTOs\TransactionDTO;
use App\Interfaces\SpecificationInterface;
use Carbon\Carbon;

readonly class DateBeforeSpecification implements SpecificationInterface
{
    public function __construct(
        private string $date_string
    ) {} //phpcs:ignore

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        $specifiedDate = Carbon::createFromFormat('Y-m-d', $this->date_string);
        $transactionDate = Carbon::createFromFormat('Y-m-d', $transaction->date);

        return $specifiedDate->lte($transactionDate);
    }
}
