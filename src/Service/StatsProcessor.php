<?php

namespace App\Service;

class StatsProcessor
{
    public function compute()
    {
        // suppose heavy processing
        sleep(10);

        return 3.14;
    }
}