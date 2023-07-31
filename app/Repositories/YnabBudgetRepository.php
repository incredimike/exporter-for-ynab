<?php

namespace App\Repositories;

use App\Budget\TransactionCollection;
use App\DTOs\TransactionDTO;
use App\Exceptions\BudgetAuthorizationException;
use App\Exceptions\BudgetConnectionException;
use App\Exceptions\BudgetRateLimitException;
use App\Exceptions\BudgetResourceNotFoundException;
use App\Interfaces\BudgetRepositoryInterface;

class YnabBudgetRepository extends BudgetRepository implements BudgetRepositoryInterface
{
    protected string $budgetId = 'last-used';
    protected string $serviceName = 'YNAB';
    protected string $serviceUrl = 'https://api.ynab.com/v1';

    /**
     * @throws BudgetResourceNotFoundException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     * @throws BudgetConnectionException
     */
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

    /**
     * @throws BudgetResourceNotFoundException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     * @throws BudgetConnectionException
     */
    public function fetchBudgets(bool $include_accounts = false): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets',
            $this->getBudgetId()
        );
        $params = http_build_query([
            'include_accounts' => $include_accounts,
        ]);
        return $this->fetchJson($url . '?' . $params, 'data.budgets');
    }

    /**
     * @throws BudgetResourceNotFoundException
     * @throws BudgetConnectionException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     */
    public function fetchCategories(): array
    {
        $url = sprintf(
            $this->serviceUrl . '/budgets/%s/categories',
            $this->budgetId
        );
        return $this->fetchJson($url, 'data.categories');
    }

    /**
     * @throws BudgetResourceNotFoundException
     * @throws BudgetConnectionException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     */
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

    /**
     * @throws BudgetResourceNotFoundException
     * @throws BudgetConnectionException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     */
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

    /**
     * @throws BudgetResourceNotFoundException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     * @throws BudgetConnectionException
     */
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
     * @throws BudgetResourceNotFoundException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
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
