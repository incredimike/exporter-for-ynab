<?php

namespace App\Interfaces;

use App\Budget\TransactionCollection;
use App\DTOs\TransactionDTO;

interface BudgetRepositoryInterface
{
    public function fetchAccounts(): array;
    public function fetchBudgets(): array;
    public function fetchCategories(): array;
    public function fetchPayees(): array;
    public function getServiceName(): string;
    public function fetchTransactions(string $sinceDate): array;
    public function fetchTransaction(string $id): array;
}
