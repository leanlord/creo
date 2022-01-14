<?php

    namespace App\Services\Filters;

    use App\Models\Flats;

    class NumericFilter extends AbstractFilter
    {
        /**
         * Numeric filtering attributes for
         * "between" operator
         *
         * @var string[]
         */
        protected static array $filteringAttributes = [
            'min_price',
            'max_price',
            'max_square',
            'min_square',
        ];

        /**
         * Minimal and Maximal values of countable attributes
         *
         * @var array
         */
        protected static array $minMaxValues = []; // TODO не знаю как по нормальному назвать массив

        /**
         * @return string[]
         */
        public static function getFilteringAttributes(): array {
            return self::$filteringAttributes;
        }

        /**
         * Обработка всех числовых параметров запроса,
         * с использованием агрегатных функций SQL.
         * Параметры должны начинаться с <агрегатная функция>_
         * Затем, начало обрезается и происходит вычисление
         * этой агрегатной функции по оставшейся строке.
         * Так, например, запрос с названием max_price выполнит
         * вычисление функции MAX() по столбцу price.
         */
        public function setFilteringValues(): void {
            foreach (static::$filteringAttributes as $attribute) {
                $userParam = $this->request->get($attribute);

                $userParam !== null ?
                    $this->filteringValues[$attribute] = (int)$userParam :
                    $this->filteringValues[$attribute] = static::$minMaxValues[$attribute];
            }
        }

        public static function setMinMaxValues() {
            foreach (static::$filteringAttributes as $attribute) {
                $agregateFunction = stristr($attribute, '_', true);
                static::$minMaxValues[$attribute] = Flats::$agregateFunction(
                    static::attributeName($attribute)
                );
            }
        }

        /**
         * Добавление условия всех минимальных\максимальных значений
         *
         * @param $query
         */
        public function filter($query): void {
            foreach (static::$filteringAttributes as $attribute) {
                $name = static::attributeName($attribute);
                $query->whereBetween('flats.' . $name, [
                    $this->filteringValues['min_' . $name],
                    $this->filteringValues['max_' . $name],
                ]);
            }
        }

        public static function attributeName(string $attribute) {
            return substr(strrchr($attribute, '_'), 1);
        }

        /**
         * @param string $name
         * @return int
         */
        public static function getMinMaxValues(string $name): int {
            return static::$minMaxValues[$name];
        }
    }
