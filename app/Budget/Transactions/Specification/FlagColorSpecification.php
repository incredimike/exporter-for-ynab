<?php

namespace App\Budget\Transactions\Specification;

use App\DTOs\TransactionDTO;
use App\Interfaces\SpecificationInterface;

readonly class FlagColorSpecification implements SpecificationInterface
{
    public function __construct(
        public string $color
    ) {}

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        return $transaction->flag_color === $this->color;
    }
}
