<?php

namespace App\Budget\Services;

class YnabBudgetExportService extends BudgetExportService
{
    protected string $base_api_url = 'https://api.ynab.com/v1';
    protected string $transaction_list_uri = '/budgets/%s/transactions';

    protected function getBaseApiUrl(): string
    {
        return $this->base_api_url;
    }

    protected function getTransactionListUrl(): string
    {
        return $this->base_api_url . $this->transaction_list_uri;
    }

    protected function getRequestUrl(): string
    {
        return sprintf(
            $this->getTransactionListUrl(),
            $this->getExportCriteria()->getBudgetId()
        );
    }

    protected function getJsonKey(): string
    {
        return 'data.transactions';
    }
}
