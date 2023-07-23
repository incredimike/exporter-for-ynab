<?php

namespace App\Services;

use App\Budget\ExportServiceInterface;
use Illuminate\Support\Facades\Http;

class YnabBudgetExportService implements ExportServiceInterface
{
    protected string $api_url = 'https://api.ynab.com/v1';

    public function __construct(
        protected string $token,
        protected string $start_date = '',
        protected string $budget_id = 'last-used'
    ) {}

    public function setStartDate(string $start_date): static
    {
        $this->start_date = $start_date;
        return $this;
    }

    public function setBudget(string $string): static
    {
        $this->budget_id = $string;
        return $this;
    }

    public function execute(): array
    {
        $url = sprintf(
            '%s/budgets/%s/transactions',
            $this->api_url,
            $this->budget_id
        );
        $response = Http::withToken($this->token)->get($url);
        if ($response->failed()) {
            return [];
        }
        return $response->json('data.transactions');
    }
}
