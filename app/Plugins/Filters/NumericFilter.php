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
    protected array $filteringAttributes = ['price', 'square'];
    protected array $minMaxValues = []; // TODO не знаю как по нормальному назвать массив

    public function setFilteringValues($request): void
    {
        /*
         * Обработка всех числовых параметров запроса,
         * с использованием агрегатных функций SQL.
         * Параметры должны начинаться с <агрегатная функция>_
         * Затем, начало обрезается и происходит вычисление
         * этой агрегатной функции по оставшейся строке.
         * Так, например, запрос с названием max_price выполнит
         * вычисление функции MAX() по столбцу price.
         */
        foreach ($this->filteringAttributes as $attribute) {

            foreach (['min', 'max'] as $agregateFunction) {

                $paramName = $agregateFunction . '_' . $attribute;
                $this->minMaxValues[$paramName] = Flats::$agregateFunction($attribute);
                $userParam = $request->get($paramName);

                $userParam !== null ?
                    $this->filteringValues[$paramName] = (int)$userParam :
                    $this->filteringValues[$paramName] = $this->minMaxValues[$paramName];
            }
        }
    }

    public function filter($query): void
    {
        // Добавление условия всех минимальных\максимальных значений
        foreach ($this->filteringAttributes as $attribute) {
            $query->whereBetween('flats.' . $attribute, [
                $this->filteringValues['min_' . $attribute],
                $this->filteringValues['max_' . $attribute]
            ]);
        }
    }

    /**
     * @param string $name
     * @return int
     */
    public function getMinMaxValues(string $name): int {
        return $this->minMaxValues[$name];
    }
}
