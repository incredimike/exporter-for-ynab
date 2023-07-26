<?php

namespace App\Budget;

use Carbon\Carbon;

class ExportCriteria
{
    protected array $errors = [];
    protected array $allowed_columns = [
        'account_name',
        'amount',
        'approved',
        'category_name',
        'cleared',
        'date',
        'flag_color',
        'memo',
        'payee_name',
    ];

    protected array $filterable_columns = [
        'account_name',
        'approved',
        'category_name',
        'flag_color',
        'memo',
        'payee_name',
    ];

    private string $budgetId = 'last-used';

    protected string $startDate;
    protected string $endDate = '';
    protected string $sortBy = 'date';
    protected array $columns = [
        'date',
        'payee_name',
        'amount',
        'account_name',
        'category_name',
        'flag_color',
        'approved',
        'cleared',
        'memo',
    ];
    protected array $include = [];
    protected array $exclude = [];


    public function getStartDate(): string
    {
        return $this->startDate;
    }


    public function getEndDate(): string
    {
        return $this->endDate;
    }


    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getInclude(): array
    {
        return $this->include;
    }

    /**
     * @return array
     */
    public function getExclude(): array
    {
        return $this->exclude;
    }

    public function isValid(): bool
    {
        $this->errors = [];
        // Validate the start and end dates
        if (!empty($this->endDate)) {
            if ((new Carbon($this->startDate))->greaterThan(new Carbon($this->endDate))) {
                $this->errors[] = 'The end date must occur after the start date';
            }
        }
        // Validate the columns
        $unexpected_columns = array_diff($this->columns, $this->allowed_columns);
        if (!empty($unexpected_columns)) {
            $this->errors[] = 'Columns contains unexpected values: ' . implode(', ', $unexpected_columns);
        }

        // Validate the include columns
        $unexpected_columns = array_diff($this->include, $this->allowed_columns);
        if (!empty($unexpected_columns)) {
            $this->errors[] = 'Include contains unexpected values: ' . implode(', ', $unexpected_columns);
        }

        // Validate the exclude columns
        $unexpected_columns = array_diff($this->exclude, $this->allowed_columns);
        if (!empty($unexpected_columns)) {
            $this->errors[] = 'Exclude contains unexpected values: ' . implode(', ', $unexpected_columns);
        }

        return empty($this->errors);
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @param  string  $endDate
     */
    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @param  string  $sortBy
     */
    public function setSortBy(string $sortBy): void
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return string
     */
    public function getBudgetId(): string
    {
        return $this->budgetId;
    }

    /**
     * @param  string  $budgetId
     */
    public function setBudgetId(string $budgetId): void
    {
        $this->budgetId = $budgetId;
    }

    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    private function setInclude(array $include): void
    {
        $this->include = $include;
    }

    public function fromRequestArray(array $criteriaArray): self
    {
        $this->setStartDate($criteriaArray['start_date']);
        $this->setEndDate($criteriaArray['end_date'] ?? '');
        $this->setSortBy($criteriaArray['sort_by'] ?? 'date');
        $this->setColumns($criteriaArray['columns'] ?? []);
        $this->setInclude($criteriaArray['include'] ?? []);

        return $this;
    }
}
