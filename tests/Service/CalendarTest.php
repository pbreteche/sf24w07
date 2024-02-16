<?php

namespace App\Tests\Service;

use App\Service\Calendar;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testIsWeekend()
    {
        $calendar = new Calendar();

        $result = $calendar->isWeekend(new \DateTimeImmutable('2024-02-16'));

        $this->assertEquals(false, $result, 'Friday should not be weekend');
    }
}
