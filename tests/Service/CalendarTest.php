<?php

namespace App\Tests\Service;

use App\Service\Calendar;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    #[DataProvider('isWeekendProvider')]
    public function testIsWeekend(string $dateInput, bool $expected)
    {
        $calendar = new Calendar();

        $result = $calendar->isWeekend(new \DateTimeImmutable($dateInput));

        $this->assertEquals($expected, $result, 'Friday should not be weekend');
    }

    public static function isWeekendProvider(): array
    {
        return [
            ['2024-02-16', false],
            ['2024-02-18', true],
            ['2023-02-16', false],
        ];
    }
}
