<?php

namespace App\Plugins\Filters;

use App\Plugins\Settings\FlatsSettings;
use App\Models\Flats;
use Illuminate\Http\Request;

class NumericFilter extends BaseFilter
{
    /**
     * Numeric filtering attributes for
     * "between" operator
     *
     * @var string[]
     */
    protected static $filteringAttributes = ['price', 'square'];

    public static function getFilteringValues($request): array
    {
        $result = [];

        /*
         * Обработка всех числовых параметров запроса,
         * с использованием агрегатных функций SQL.
         * Параметры должны начинаться с <агрегатная функция>_
         * Затем, начало обрезается и происходит вычисление
         * этой агрегатной функции по оставшейся строке.
         * Так, например, запрос с названием max_price выполнит
         * вычисление функции MAX() по столбцу price.
         */
        foreach (static::$filteringAttributes as $attribute) {

            foreach (['min', 'max'] as $agregateFunction) {

                $userParam = $request->get($agregateFunction . '_' . $attribute);

                $userParam !== null ?
                    $result[$agregateFunction . '_' . $attribute] = (int)$userParam :
                    $result[$agregateFunction . '_' . $attribute] = Flats::$agregateFunction($attribute);
            }
        }

        return $result;
    }

    public function filter($query)
    {
        // Добавление условия всех минимальных\максимальных значений
        foreach (static::$filteringAttributes as $attribute) {
            $query->whereBetween('flats.' . $attribute, [
                $this->filteringValues['min_' . $attribute],
                $this->filteringValues['max_' . $attribute]
            ]);
        }
    }
}
