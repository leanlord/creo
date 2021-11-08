<?php

namespace App\Plugins;

use App\Models\Flats;

class Filter
{
    protected static $stringAttributes = [
        'city',
        'company',
        'area',
    ];

    public static $intAttributes = [
        'min_price',
        'max_price',
        'min_square',
        'max_square'
    ];

    public static function getCountOfStringAttributes(): int
    {
        return count(static::$stringAttributes);
    }

    public static function getCountOfNumberAttributes(): int {
        return count(static::$intAttributes);
    }

    public static function getUniqueColumnValues(string $columnName): array
    {
        $columnValues = Flats::all($columnName);
        $result = [];
        foreach ($columnValues as $value) {
            $result[] = $value->getAttribute($columnName);
        }

        return array_unique($result);
    }

    public static function getAllAttributes($request): array
    {
        foreach (static::$stringAttributes as $strAttribute) {
            $result[$strAttribute] = $request->get($strAttribute) ?? '%';
        }

        // Автоматическая обработка всех параметров запроса
        foreach (static::$intAttributes as $intAttribute) {
            if (str_contains($intAttribute, 'max')) {
                $result[$intAttribute] = $request->get($intAttribute) ??
                    Flats::max(
                        str_replace('max_', '', $intAttribute)
                    );
            } elseif (str_contains($intAttribute, 'min')) {
                $result[$intAttribute] = $request->get($intAttribute) ??
                    Flats::min(
                        str_replace('min_', '', $intAttribute)
                    );
            } elseif (str_contains($intAttribute, 'count')) {
                $result[$intAttribute] = $request->get($intAttribute) ??
                    Flats::count(
                        str_replace('count_', '', $intAttribute)
                    );
            }

            $result[$intAttribute] = (int) $result[$intAttribute];
        }

        return $result;
    }
}
