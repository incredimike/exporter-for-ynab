<?php

namespace App\Budget\Services;

use App\Budget\ExportCriteria;
use App\Exceptions\BudgetServiceConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BudgetExportService
{
    protected ExportCriteria $criteria;

    protected string $token = ''; // @todo store in criteria?

    protected Response $response;

    public function execute(): array
    {
        $url = $this->getRequestUrl();
        $this->response = Http::withToken($this->getToken())
            ->get($url);

        if ($this->response->failed()) {
            throw new BudgetServiceConnectionException(
                get_class($this) . ' cannot connect connect to API',
                $this->response->status()
            );
        }
        return $this->response->json($this->getJsonKey(), []);
    }

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
