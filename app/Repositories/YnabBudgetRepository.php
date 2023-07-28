<?php

namespace App\Repositories;

use App\Interfaces\BudgetRepositoryInterface;

class YnabBudgetRepository extends BudgetRepository implements BudgetRepositoryInterface
{
    protected string $budgetId = 'last-used';
    protected string $serviceName = 'YNAB';
    protected string $serviceUrl = 'https://api.ynab.com/v1';

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getTransactionsSince(string $date): array
    {
        $base_url = sprintf(
            $this->serviceUrl .  '/budgets/%s/transactions',
            $this->budgetId
        );
        $query_params = http_build_query([
            'since_date' => $date,
        ]);

        return $this->fetchJson($base_url . '?' . $query_params, 'data.transactions');
    }

    public function getTransaction(string $id): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/transactions/%s',
            $this->budgetId,
            $id
        );
        return $this->fetchJson($url, 'data.transaction');
    }

    public function getBudgetId(): string
    {
        return $this->budgetId;
    }

    public function setBudgetId(string $budgetId): void
    {
        $this->budgetId = $budgetId;
    }
}
