<?php

namespace App\Factories;

abstract class BaseFactory
{
    protected int $count = 10;

    public function make()
    {
        $payees = [];
        for ($i = 0; $i < $this->count; $i++) {
            $payees[] = $this->generateFactoryItem();
        }
        return $payees;
    }

    public function count($count): self
    {
        $this->count = $count;
        return $this;
    }

    abstract protected function generateFactoryItem(): array;
}
