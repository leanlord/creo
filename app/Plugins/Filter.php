<?php

namespace App\Plugins;

use App\Models\City;
use App\Models\Company;
use App\Models\Flats;
use App\Models\Area;

class Filter
{
    /**
     * String filtering attributes - like name, city or color
     *
     * @var string[]
     */
    protected static $stringAttributes = [
        'city',
        'company',
        'area',
    ];

    /**
     * Numeric attributes - like min_price, count or horse powers
     *
     * @var string[]
     */
    protected static $intAttributes = [
        'min_price',
        'max_price',
        'min_square',
        'max_square'
    ];

    public static function getCountOfStringAttributes(): int
    {
        return count(static::$stringAttributes);
    }

    public static function getCountOfNumericAttributes(): int
    {
        return count(static::$intAttributes);
    }


    /**
     * Returns column data from all connected(related) tables
     *
     * @param string $columnName
     * @return array
     */
    public static function getUniqueColumnValues(string $columnName): array
    {
        $result = [];
        /*
         * Производится поиск всех значений id
         * по заданному столбцу связи.
         * Те значения, которые не имеют связи,
         * не попадут в массив данных.
         */
        $allIDs = Flats::all($columnName . '_id');

        /*
         * Формируется массив значений из заданной таблицы
         */
        foreach ($allIDs as $id) {
            if ($columnName == 'city') {
                $result[] = City::find($id)[0]->city;
            } elseif ($columnName == 'company') {
                $result[] = Company::find($id)[0]->name;
            } elseif ($columnName == 'area') {
                $result[] = Area::find($id)[0]->name;
            }
        }

        return array_unique($result);
    }

    public static function getAllAttributes($request): array
    {
        $result = [];

        /*
         * Обработка всех строковых параметров запроса.
         * Если GET параметр существует, то задается
         * значение id аттрибута, которое будет использовано
         * как условие в запросе к БД.
         * Иначе, задается "любое значение".
         * (в SQL '%' означает "последовательность любых символов любой длины")
         */
        foreach (self::$stringAttributes as $stringAttribute) {
            $result[$stringAttribute] = $request->get($stringAttribute) ?? '';
        }

        /*
         * Обработка всех числовых параметров запроса,
         * с использованием агрегатных функций SQL.
         * Параметры должны начинаться с <агрегатная функция>_
         * Затем, начало обрезается и происходит вычисление
         * этой агрегатной функции по оставшейся строке.
         * Так, например, запрос с названием max_price выполнит
         * вычисление функции MAX() по столбцу price.
         */
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

            $result[$intAttribute] = (int)$result[$intAttribute];
        }

        return $result;
    }
}
