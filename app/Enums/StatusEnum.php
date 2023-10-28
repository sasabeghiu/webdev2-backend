<?php

namespace App\Enums;

class StatusEnum
{
    const SCHEDULED = 'Scheduled';
    const COMPLETED = 'Completed';
    const RESCHEDULED = 'Rescheduled';
    const CANCELLED = 'Cancelled';

    public static function getStatuses()
    {
        return [
            self::SCHEDULED,
            self::COMPLETED,
            self::RESCHEDULED,
            self::CANCELLED,
        ];
    }
}
