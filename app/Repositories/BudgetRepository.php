<?php

namespace App\Repositories;

use App\Budget\ExportCriteria;
use App\Exceptions\BudgetServiceConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BudgetRepository
{
    protected ExportCriteria $criteria; // remove this too.

    protected Response $response;

    protected string $token = '';

    public function fetchJson(string $url, string $jsonKey): array
    {
        $this->response = Http::withToken($this->getToken())
            ->get($url);

        if ($this->response->failed()) {
            throw new BudgetServiceConnectionException(
                get_class($this) . ' cannot connect connect to API',
                $this->response->status()
            );
        }
        return $this->response->json($jsonKey, []);
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
