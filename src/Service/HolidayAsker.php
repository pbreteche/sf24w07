<?php

namespace App\Service;

readonly class HolidayAsker
{
    public function __construct(
        private Calendar $calendar,
    ) {
    }

    public function askFor(\DateTimeInterface $start, \DateTimeInterface $end): int
    {
        $current = \DateTime::createFromInterface($start);
        $count = 0;

        for (; $current <= $end; $current->modify('+1 day')) {
            $count += $this->calendar->isDayOff($current) ? 0 : 1;
        }

        return $count;
    }
}
