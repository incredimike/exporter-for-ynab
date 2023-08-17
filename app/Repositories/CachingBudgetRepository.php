<?php

namespace App\Repositories;

use App\Interfaces\BudgetRepositoryInterface;
use Cache;

class CachingBudgetRepository implements BudgetRepositoryInterface
{
    protected BudgetRepository $repository;
    protected string $serviceName = 'Cache';

    public function __construct(BudgetRepository $repository)
    {
        $this->repository = $repository;
    }

    private function makeCacheKey(string $id): string
    {
        return sprintf(
            '%s.%s.%s',
            strtolower($this->repository->getServiceName()),
            $this->repository->getBudgetId(),
            $id
        );
    }

    public function fetchAccounts(): array
    {
        return Cache::remember($this->makeCacheKey('accounts'), $minutes = 10, function () {
            return $this->repository->fetchAccounts();
        });
    }

    public function fetchBudgets(bool $include_accounts = false): array
    {
        return Cache::remember($this->makeCacheKey('budgets'), $minutes = 10, function () {
            return $this->repository->fetchBudgets();
        });
    }

    public function fetchCategories(): array
    {
        return Cache::remember($this->makeCacheKey('categories'), $minutes = 10, function () {
            return $this->repository->fetchBudgets();
        });
    }

    public function fetchPayees(): array
    {
        return Cache::remember($this->makeCacheKey('payees'), $minutes = 10, function () {
            return $this->repository->fetchPayees();
        });
    }

    public function fetchTransactions(string $sinceDate): array
    {
        return Cache::remember($this->makeCacheKey('transactions'), $minutes = 10, function () {
            return $this->repository->fetchPayees();
        });
    }

    public function getBudgetId(): string
    {
        return $this->budgetId;
    }

    public function fetchTransaction(string $id): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/transactions/%s',
            $this->budgetId,
            $id
        );
        return $this->fetchJson($url, 'data.transaction');
    }

    public function getServiceName(): string
    {
        return $this->serviceName . ' <- ' . $this->repository->getServiceName();
    }

    public function setBudgetId(string $budgetId): void
    {
        $this->budgetId = $budgetId;
    }
}
