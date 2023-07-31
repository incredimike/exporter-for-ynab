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
    protected Response $response;

    protected string $accessToken = '';

    /**
     * @throws BudgetConnectionException
     * @throws BudgetAuthorizationException
     * @throws BudgetRateLimitException
     * @throws BudgetResourceNotFoundException
     */
    public function fetchJson(string $url, string $jsonKey): array
    {
        $this->response = Http::withToken($this->getAccessToken())->get($url);

        if ($this->response->failed()) {
            $status = $this->response->status();
            $reason = $this->response->reason();
            if (401 === $status || 403 === $status) {
                throw new BudgetAuthorizationException($reason, $status);
            }
            if (404 === $status) {
                throw new BudgetResourceNotFoundException($reason, $status);
            }
            if (429 === $status) {
                throw new BudgetRateLimitException($reason, $status);
            }
            throw new BudgetConnectionException(
                sprintf(
                    '%s unsable to connect to %s API: %s',
                    get_class($this),
                    $this->getServiceName(),
                    $this->response->reason()
                ),
                $status
            );
        }
        return $this->response->json($jsonKey, []);
    }

    abstract public function getServiceName(): string;

    public function setAccessToken(string $token): void
    {
        $this->accessToken = $token;
    }

    private function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getLastHttpResponse(): Response
    {
        return $this->response;
    }
}
