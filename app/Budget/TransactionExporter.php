<?php

namespace App\Budget;

use App\Budget\Services\YnabTransactionsExportService;
use App\Exceptions\BudgetServiceConnectionException;

class TransactionExporter
{
    private ExportCriteria $criteria;
    private string $api_token;

    public function __construct(
        private readonly YnabTransactionsExportService $exportService
    ) {} // phpcs:ignore

    /**
     * @throws BudgetServiceConnectionException
     */
    public function export(ExportCriteria $criteria = null): TransactionCollection
    {
        $this->exportService->setExportCriteria($criteria ?? $this->criteria);
        $this->exportService->setToken($this->api_token);
        $responseArray = $this->exportService->execute();

        //


        return new TransactionCollection($responseArray);
    }

    public function setCriteria(ExportCriteria $criteria): void
    {
        $this->criteria = $criteria;
    }

    public function setToken(string $token): void
    {
        $this->api_token = $token;
    }

    public function getExportService(): YnabTransactionsExportService
    {
        return $this->exportService;
    }
    public function getExportServiceName(): string
    {
        return $this->exportService->getServiceName();
    }
}
