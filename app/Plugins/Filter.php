<?php

namespace App\Plugins;

use App\Models\Flats;
use Illuminate\Support\Facades\DB;

class Filter
{
    /**
     * Returns columns data from all connected(related) tables
     *
     * @return array
     */
    public static function getUniqueColumnsValues(): array
    {
        foreach (Settings::getRelatedTables() as $table) {
            $allValues[$table] = json_decode(json_encode(DB::table($table)->select()->get()), true);
        }

        return $allValues;
    }

    public static function getAllAttributes($request): array
    {
        $result = [];

        /*
         * Обработка всех строковых параметров запроса.
         * Если GET параметр существует, то задается
         * значение этого параметра, которое будет использовано
         * как условие в запросе к БД.
         * Иначе, задается "любое значение".
         * (в SQL '%' означает "последовательность любых символов любой длины")
         */
        foreach (Settings::getStringFilteringAttributes() as $stringAttribute) {
            $result[$stringAttribute] = $request->get($stringAttribute) ?? '%';
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
        foreach (Settings::getIntFilteringAttributes() as $intAttribute) {
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
