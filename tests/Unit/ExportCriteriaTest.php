<?php

namespace Tests\Unit;

use App\Budget\ExportCriteria;
use PHPUnit\Framework\TestCase;

class ExportCriteriaTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_start_date_only_is_valid(): void
    {
        $startDate = '2023-01-01';

        // Create the search criteria object
        $exportCriteria = new ExportCriteria($startDate);

        $this->assertTrue($exportCriteria->isValid());

        $this->assertEquals($startDate, $exportCriteria->getStartDate());
        $this->assertEquals('', $exportCriteria->getEndDate());
        $this->assertEquals('date', $exportCriteria->getSortBy());
    }
}
