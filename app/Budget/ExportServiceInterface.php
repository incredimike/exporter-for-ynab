<?php

namespace App\Budget;

interface ExportServiceInterface
{
    public function setToken(string $token): void;
    public function execute(): array;
}
