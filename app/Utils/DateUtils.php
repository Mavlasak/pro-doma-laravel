<?php declare(strict_types=1);

namespace App\Utils;

class DateUtils
{
    public static function subtractStringDateTimes(string $dateStart, string $dateEnd): array
    {
        $datetime1 = new \DateTimeImmutable($dateStart);
        $datetime2 = new \DateTimeImmutable($dateEnd);
        $interval = $datetime1->diff($datetime2);

        return [
            'days' => $interval->format('%a'),
            'hours' => $interval->format('%h'),
            'minutes' => $interval->format('%i'),
        ];
    }
}
