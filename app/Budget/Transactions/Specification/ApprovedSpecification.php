<?php

namespace App\Budget\Transactions\Specification;

use App\Interfaces\SpecificationInterface;
use App\DTOs\TransactionDTO;

readonly class ApprovedSpecification implements SpecificationInterface
{
    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        return $transaction->approved;
    }
}
