<?php

namespace App\Service;

use DateTime;
use DateTimeZone;

class DateService
{
    public function getDateTimeMadagascar(): DateTime
    {
        $timeZone = new DateTimeZone('Indian/Antananarivo');
        return new DateTime('now', $timeZone);
    }
}
