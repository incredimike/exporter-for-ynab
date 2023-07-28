<?php

namespace App\Interfaces;

interface BudgetRepositoryInterface
{
    public function getServiceName(): string;
    public function getTransactionsSince(string $date): array;
}
