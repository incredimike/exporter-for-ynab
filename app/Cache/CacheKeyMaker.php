<?php

namespace App\Cache;

use App\Models\User;

class CacheKeyMaker
{
    protected string $budgetId;
    protected string $serviceName;

    public function __construct(
        protected readonly User $user
    ) {}

    public function setServiceName(string $serviceName): self
    {
        $this->serviceName = strtolower($serviceName);
    }

    public function setBudgetId(string $budgetId): self
    {
        $this->budgetId = strtolower($budgetId);
    }

    public function makeKey(string $cache_key): string
    {
        return sprintf(
            '%s.%s.%s.%s',
            $this->serviceName,
            $this->user->id,
            $this->budgetId,
            $cache_key
        );
    }
}
