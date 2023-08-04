<?php

namespace App\Budget\Transactions\Specification;

use App\Interfaces\SpecificationInterface;
use App\DTOs\TransactionDTO;

readonly class CategoryIdSpecification implements SpecificationInterface
{
    public function __construct(
        private string $id
    ) {}

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        return $transaction->category_id === $this->id;
    }
}
