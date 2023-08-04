<?php

namespace App\Budget\Transactions\Specification;

use App\Interfaces\SpecificationInterface;
use App\DTOs\TransactionDTO;

readonly class PayeeIdSpecification implements SpecificationInterface
{
    public function __construct(
        private string $payee_id
    ) {}

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        return $transaction->payee_id === $this->payee_id;
    }
}
