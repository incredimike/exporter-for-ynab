<?php

namespace App\Budget\Services;

use App\Budget\ExportCriteria;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BudgetExportService
{
    protected ExportCriteria $criteria;

    protected string $token = ''; // @todo store in criteria?

    protected Response $response;

    public function execute(): array
    {
        $this->response = Http::withToken($this->getToken())
            ->get($this->getRequestUrl());

        if ($this->response->failed()) {
            return [];
        }
        return $this->response->json($this->getJsonKey(), []);
    }

    abstract protected function getBaseApiUrl(): string;
    abstract protected function getJsonKey(): string;

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
        return $this->response;
    }
}
