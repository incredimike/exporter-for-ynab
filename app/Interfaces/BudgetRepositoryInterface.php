<?php

namespace App\Interfaces;

use App\DTOs\TransactionDTO;

interface BudgetRepositoryInterface
{
    public function getServiceName(): string;
    public function getTransactionsSince(string $date): array;
    public function getTransaction(string $id): array;
}
