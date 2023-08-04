<?php

namespace App\Budget\Transactions\Specification;

use App\DTOs\TransactionDTO;
use App\Interfaces\SpecificationInterface;

class OrSpecification implements SpecificationInterface
{
    protected array $specifications;

    public function __construct(SpecificationInterface ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($transaction)) {
                return true;
            }
        }
        return false;
    }
}
