<?php

namespace App\Budget;

class BudgetExporter
{
    public function __construct(
        protected ExportServiceInterface $service,
        protected ExportCriteria $criteria,
    ) {}
}
