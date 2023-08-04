<?php

namespace App\Budget\Transactions\Specification;

class MemoTextSpecification implements SpecificationInterface
{
    private string $searchString;

    public function __construct(string $searchString)
    {
        $this->searchString = $searchString;
    }

    public function isSatisfiedBy(TransactionDTO $transaction): bool
    {
        $memo = $transaction->getMemo();
        return strpos($memo, $this->searchString) !== false;
    }
}
