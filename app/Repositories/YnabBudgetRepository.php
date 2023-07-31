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

    public function fetchAccounts(): array
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

    public function fetchBudgets(bool $include_accounts = false): array
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

    public function fetchCategories(): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/categories',
            $this->budgetId
        );
        return $this->fetchJson($url, 'data.categories');
    }

    public function fetchPayees(): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/payees',
            $this->budgetId
        );
        return $this->fetchJson($url, 'data.payees');
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function fetchTransactions(string $sinceDate): array
    {
        $url = sprintf(
            $this->serviceUrl .  '/budgets/%s/transactions',
            $this->budgetId
        );
        $params = http_build_query([
            'since_date' => $sinceDate,
        ]);

        return $this->fetchJson($url . '?' . $params, 'data.transactions');
    }

    public function findTransactionsSince(string $sinceDate): TransactionCollection
    {
        $transactions = $this->fetchTransactions($sinceDate);
        return new TransactionCollection($transactions);
    }

    /**
     * @throws BudgetConnectionException
     */
    public function findTransactionById(string $id): TransactionDTO
    {
        return TransactionDTO::fromArray($this->fetchTransaction($id));
    }

    /**
     * @throws BudgetConnectionException
     */
    public function fetchTransaction(string $id): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/transactions/%s',
            $this->budgetId,
            $id
        );
        return $this->fetchJson($url, 'data.transaction');
    }
}
