<?php

namespace App\Repositories;

use App\Interfaces\BudgetRepositoryInterface;

class YnabBudgetRepository extends BudgetRepository implements BudgetRepositoryInterface
{
    protected string $serviceUrl = 'https://api.ynab.com/v1';
    protected string $serviceName = 'YNAB';
    protected string $budgetId = 'last-used';

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getTransactionsSince(string $sinceDate): array
    {
        $base_url = sprintf(
            $this->serviceUrl .  '/budgets/%s/transactions',
            $this->budgetId
        );
        $query_params = http_build_query([
            'since_date' => $sinceDate,
        ]);

        return $this->fetchJson($base_url . '?' . $query_params, 'data.transactions');
    }
}
