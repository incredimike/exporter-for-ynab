<?php

namespace App\Budget\Transactions\Specification;

use App\Interfaces\SpecificationInterface;
use App\DTOs\TransactionDTO;

readonly class AccountIdSpecification implements SpecificationInterface
{
    public function __construct(
        private string $account_id
    ) {}

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        return $transaction->account_id === $this->account_id;
    }
}
