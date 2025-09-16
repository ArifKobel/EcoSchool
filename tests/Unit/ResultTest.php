<?php

namespace Tests\Unit;

use App\Models\Result;
use Tests\TestCase;

class ResultTest extends TestCase
{
    public function test_calculate_status_works_correctly(): void
    {
        $this->assertEquals('gold', Result::calculateStatus(95));
        $this->assertEquals('silver', Result::calculateStatus(80));
        $this->assertEquals('bronze', Result::calculateStatus(50));
    }

    public function test_get_status_name_returns_correct_names(): void
    {
        $result = new Result(['status' => 'gold']);
        $this->assertEquals('Gold', $result->getStatusName());

        $result = new Result(['status' => 'silver']);
        $this->assertEquals('Silber', $result->getStatusName());

        $result = new Result(['status' => 'bronze']);
        $this->assertEquals('Bronze', $result->getStatusName());
    }
}
