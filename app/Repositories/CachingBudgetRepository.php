<?php

namespace App\Repositories;

use App\Cache\CacheKeyMaker;
use App\Interfaces\BudgetRepositoryInterface;
use Cache;

class CachingBudgetRepository implements BudgetRepositoryInterface
{
    protected CacheKeyMaker $keyMaker;
    protected BudgetRepository $repository;
    protected string $serviceName = 'Cache';

    public function __construct(BudgetRepository $repository, CacheKeyMaker $keys)
    {
        $this->repository = $repository;
        $this->keyMaker = $keys;

        $this->keyMaker->setServiceName($this->repository->getServiceName());
        $this->keyMaker->setBudgetId($this->repository->getBudgetId());
    }

    public function fetchAccounts(): array
    {
        return Cache::remember($this->keyMaker->makeKey('accounts'), 10, function () {
            return $this->repository->fetchAccounts();
        });
    }

    public function fetchBudgets(bool $include_accounts = false): array
    {
        return Cache::remember($this->keyMaker->makeKey('budgets'), 10, function () {
            return $this->repository->fetchBudgets();
        });
    }

    public function fetchCategories(): array
    {
        return Cache::remember($this->keyMaker->makeKey('categories'), 10, function () {
            return $this->repository->fetchCategories();
        });
    }

    public function fetchPayees(): array
    {
        return Cache::remember($this->keyMaker->makeKey('payees'), 10, function () {
            return $this->repository->fetchPayees();
        });
    }

    public function fetchTransactions(string $sinceDate): array
    {
        return Cache::remember($this->keyMaker->makeKey('transactions'), 10, function () {
            return $this->repository->fetchTransactions();
        });
    }

    public function getBudgetId(): string
    {
        return $this->repository->getBudgetId();
    }

    public function fetchTransaction(string $id): array
    {
        return Cache::remember($this->keyMaker->makeKey('transactions'), 10, function () {
            return $this->repository->fetchPayees();
        });
    }

    public function getServiceName(): string
    {
        return $this->serviceName . ' <- ' . $this->repository->getServiceName();
    }

}
