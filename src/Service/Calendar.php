<?php

namespace App\Service;

class Calendar
{
    public function isWeekend(
        \DateTimeInterface $date,
    ): bool {
        return 5 < (int) $date->format('N');
    }

    public function isDayOff(
        \DateTimeInterface $date,
    ): bool {
        if ($this->isWeekend($date)) {
            return true;
        }

        return in_array($date->format('m-d'), [
            '01-01',
            '05-01',
            '12-25',
        ]);
    }
}
