<?php declare(strict_types=1);

namespace App\Utils;

class BladeUtils
{
    public static function setSelectedForSelect(array $options, ?array $selected): array
    {
        $selectData = [];
        foreach ($options as $key => $value) {
            $selectData[$key] = [
                'value' => $value,
                'selected' => !($selected === null) && in_array($key, $selected),
            ];
        }

        return $selectData;
    }
}
