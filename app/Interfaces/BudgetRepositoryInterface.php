<?php

namespace App\Interfaces;

use App\Budget\TransactionCollection;
use App\DTOs\TransactionDTO;

interface BudgetRepositoryInterface
{
    public function getServiceName(): string;
    public function getTransactionsSince(string $date): TransactionCollection;
    public function getTransaction(string $id): TransactionDTO;
}
