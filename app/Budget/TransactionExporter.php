<?php

namespace App\Budget;

use App\Budget\Services\YnabBudgetExportService;

class TransactionExporter
{
    private ExportCriteria $criteria;
    private string $api_token;

    public function __construct(
        private readonly YnabBudgetExportService $exportService
    ) {}

    public function export(ExportCriteria $criteria = null): TransactionCollection
    {
        $this->exportService->setExportCriteria($criteria ?? $this->criteria);
        $this->exportService->setToken( $this->api_token );
        return new TransactionCollection(
            //[]
            $this->exportService->execute()
        );
    }

    public function setCriteria(ExportCriteria $criteria): void
    {
        $this->criteria = $criteria;
    }

    public function setToken(string $token): void
    {
        $this->api_token = $token;
    }
}
