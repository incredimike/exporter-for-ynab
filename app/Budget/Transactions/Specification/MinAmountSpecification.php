<?php

namespace App\Budget\Transactions\Specification;

use App\DTOs\TransactionDTO;
use App\Interfaces\SpecificationInterface;

readonly class MinAmountSpecification implements SpecificationInterface
{
    public function __construct(
        private float $amount,
    ) {}

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        return ($transaction->amount >= $this->amount);
    }
}
