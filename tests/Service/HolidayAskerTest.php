<?php

namespace App\Tests\Service;

use App\Service\Calendar;
use App\Service\HolidayAsker;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HolidayAskerTest extends KernelTestCase
{
    private HolidayAsker $holidayAsker;

    public function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $calendar = $this->createMock(Calendar::class);
        $calendar->expects(self::any())
            ->method('isDayOff')
            ->willReturn(false, false, true, true, false, false)
        ;

        $container->set(Calendar::class, $calendar);

        $this->holidayAsker = $container->get(HolidayAsker::class);
    }

    public function testAskFor()
    {
        $count = $this->holidayAsker->askFor(
            new \DateTimeImmutable('2024-02-15'),
            new \DateTimeImmutable('2024-02-20')
        );

        $this->assertEquals(4, $count);
    }
}