<?php

namespace App\Service;

class Calendar
{
    public function isWeekend(
        \DateTimeInterface $date,
    ): bool {
        return 5 < (int) $date->format('N');
    }
}
