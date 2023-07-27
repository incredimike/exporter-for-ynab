<?php

namespace App\Budget\Services;

class YnabTransactionsExportService extends BudgetExportService
{
    protected string $service_url = 'https://api.ynab.com/v1';
    protected string $service_name = 'YNAB';

    public function getServiceName(): string
    {
        return $this->service_name;
    }

    protected function getRequestUrl(): string
    {
        $criteria = $this->getExportCriteria();
        $base_url = sprintf(
            $this->service_url .  '/budgets/%s/transactions',
            $criteria->getBudgetId()
        );
        $query_params = http_build_query([
            'since_date' => $criteria->getStartDate(),
        ]);

        return $base_url . '?' . $query_params ;
    }

    protected function getJsonKey(): string
    {
        return 'data.transactions';
    }
}
