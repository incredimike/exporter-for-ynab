<?php

namespace App\Budget\Services;

use App\Budget\ExportServiceInterface;
use Illuminate\Support\Facades\Http;

class YnabBudgetExportService implements ExportServiceInterface
{
    protected string $api_url = 'https://api.ynab.com/v1';
    protected string $start_date = '';
    protected string $budget_id = 'last-used';
    protected string $token = '';

    public function __construct()
    {}

    public function execute(): array
    {
        $url = sprintf(
            '%s/budgets/%s/transactions',
            $this->api_url,
            $this->getBudgetId()
        );
        $response = Http::withToken($this->getToken())
            ->get($url);
        if ($response->failed()) {
            return [];
        }
        return $response->json('data.transactions');
    }

    public function setStartDate(string $start_date): void
    {
        $this->start_date = $start_date;
    }

    public function setBudgetId(string $string): void
    {
        $this->budget_id = $string;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    private function getBudgetId(): string
    {
        return $this->budget_id;
    }

    private function getToken(): string
    {
        return $this->token;
    }
}
