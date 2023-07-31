<?php

namespace App\Repositories;

use App\Budget\TransactionCollection;
use App\DTOs\TransactionDTO;
use App\Exceptions\BudgetConnectionException;
use App\Interfaces\BudgetRepositoryInterface;

class YnabBudgetRepository extends BudgetRepository implements BudgetRepositoryInterface
{
    protected string $budgetId = 'last-used';
    protected string $serviceName = 'YNAB';
    protected string $serviceUrl = 'https://api.ynab.com/v1';

    public function getAccounts(): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/accounts',
            $this->budgetId
        );
        return $this->fetchJson($url, 'data.accounts');
    }
    public function getBudgetId(): string
    {
        return $this->budgetId;
    }

    public function setBudgetId(string $budgetId): void
    {
        $this->budgetId = $budgetId;
    }

    public function getBudgets(bool $include_accounts = false): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets',
            $this->budgetId
        );
        $params = http_build_query([
            'include_accounts' => $include_accounts,
        ]);
        return $this->fetchJson($url . '?' . $params, 'data.budgets');
    }

    public function getCategories(): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/categories',
            $this->budgetId
        );
        return $this->fetchJson($url, 'data.categories');
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getPayees(): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/payees',
            $this->budgetId
        );
        return $this->fetchJson($url, 'data.payees');
    }

    public function getTransactions(string $since_date): TransactionCollection
    {
        $base_url = sprintf(
            $this->serviceUrl .  '/budgets/%s/transactions',
            $this->budgetId
        );
        $query_params = http_build_query([
            'since_date' => $since_date,
        ]);

        $transactions = $this->fetchJson($base_url . '?' . $query_params, 'data.transactions');
        return new TransactionCollection($transactions);
    }

    /**
     * @throws BudgetConnectionException
     */
    public function getTransaction(string $id): TransactionDTO
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/transactions/%s',
            $this->budgetId,
            $id
        );
        $data = $this->fetchJson($url, 'data.transaction');
        return TransactionDTO::fromArray($data);
    }
}
