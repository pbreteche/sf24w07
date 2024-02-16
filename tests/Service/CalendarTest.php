<?php

namespace App\Tests\Service;

use App\Service\Calendar;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    #[DataProvider('isWeekendProvider')]
    public function testIsWeekend(string $dateInput, bool $expected)
    {
        $calendar = new Calendar();

        $result = $calendar->isWeekend(new \DateTimeImmutable($dateInput));

        $this->assertEquals($expected, $result);
    }

    public static function isWeekendProvider(): array
    {
        return [
            ['2024-02-16', false],
            ['2024-02-18', true],
            ['2023-02-16', false],
        ];
    }

    #[Depends('testIsWeekend')]
    public function testIsDayOff()
    {
        $calendar = new Calendar();

        $result = $calendar->isDayOff(new \DateTimeImmutable('2045-12-25'));

        $this->assertTrue($result);
    }
}
