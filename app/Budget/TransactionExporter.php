<?php

namespace App\Budget;

use App\Exceptions\BudgetConnectionException;
use App\Repositories\BudgetRepository;
use App\Repositories\YnabBudgetRepository;

class TransactionExporter
{
    private string $api_token;

    public function __construct(
        private readonly YnabBudgetRepository $budgetRepository,
        private readonly ExportCriteria $criteria
    ) {} // phpcs:ignore

    /**
     * @throws BudgetConnectionException
     */
    public function run(ExportCriteria $criteria = null): TransactionCollection
    {
        $criteria = $criteria ?? $this->criteria;
        $this->budgetRepository->setToken($this->api_token);
        return $this->budgetRepository->getTransactionsSince($criteria->getStartDate());
    }

    public function setToken(string $token): void
    {
        $this->api_token = $token;
    }

    public function getExportServiceName(): string
    {
        return $this->budgetRepository->getServiceName();
    }
}
