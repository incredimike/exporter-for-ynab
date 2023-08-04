<?php

namespace App\Interfaces;

use App\DTOs\TransactionDTO;

interface SpecificationInterface
{
    public function isSatisfiedBy(TransactionDTO $transaction): bool;
}
