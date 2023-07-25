<?php

namespace App\Budget\Services;

use App\Budget\ExportCriteria;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BudgetExportService
{
    protected ExportCriteria $criteria;
    protected string $api_url = 'https://api.ynab.com/v1';

    protected string $token = '';

    protected Response $http_response;

    public function execute(): array
    {
        $url = sprintf(
            '%s/budgets/%s/transactions',
            $this->api_url,
            $this->getExportCriteria()->getBudgetId()
        );
        $this->http_response = Http::withToken($this->getToken())
            ->get($url);
        if ($this->http_response->failed()) {
            return [];
        }
        return $this->http_response->json('data.transactions', []);
    }

    public function getExportCriteria(): ExportCriteria
    {
        return $this->criteria;
    }

    public function setExportCriteria(ExportCriteria $criteria): void
    {
        $this->criteria = $criteria;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    private function getToken(): string
    {
        return $this->token;
    }

    public function getLastHttpResponse(): Response
    {
        return $this->http_response;
    }
}
