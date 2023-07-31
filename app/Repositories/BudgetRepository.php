<?php

namespace App\Repositories;

use App\Budget\ExportCriteria;
use App\Exceptions\BudgetAuthorizationException;
use App\Exceptions\BudgetConnectionException;
use App\Exceptions\BudgetRateLimitException;
use App\Exceptions\BudgetResourceNotFoundException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class BudgetRepository
{
    protected ExportCriteria $criteria; // remove this too.

    protected Response $response;

    protected string $token = '';

    /**
     * @throws BudgetConnectionException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     * @throws BudgetResourceNotFoundException
     */
    public function fetchJson(string $url, string $jsonKey): array
    {
        $this->response = Http::withToken($this->getToken())->get($url);

        if ($this->response->failed()) {
            if ($this->response->status() === 401 || $this->response->status() === 403) {
                throw new BudgetAuthorizationException();
            }
            if ($this->response->status() === 404) {
                throw new BudgetResourceNotFoundException();
            }
            if ($this->response->status() === 429) {
                throw new BudgetRateLimitException();
            }
            throw new BudgetConnectionException(
                get_class($this) . ' unable to connect to ' . $this->getServiceName() . ' API',
                $this->response->status()
            );
        }
        return $this->response->json($jsonKey, []);
    }

    abstract public function getServiceName(): string;

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
