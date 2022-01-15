<?php

    namespace App\Services\Filters;

    use App\Models\Flat;

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
         * Setting of concrete values to filtering.
         * Parameters must start with [function]_ (min_, max_, etc.)
         */
        public function setFilteringValues(): void {
            foreach (static::$filteringAttributes as $attribute) {
                $userParam = $this->request->get($attribute);

                $userParam !== null ?
                    $this->filteringValues[$attribute] = (int)$userParam :
                    $this->filteringValues[$attribute] = static::$minMaxValues[$attribute];
            }
        }

        /**
         * Setting of all min and max values
         * with SQL agregate functions.
         */
        public static function setMinMaxValues() {
            foreach (static::$filteringAttributes as $attribute) {
                $functionName = stristr($attribute, '_', true);
                static::$minMaxValues[$attribute] = Flat::$functionName(
                    static::attributeName($attribute)
                );
            }
        }

        /**
         * Adds the conditions to query
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

        /**
         * Get the name of attribute from string
         * like function_name (min_price)
         *
         * @param string $attribute
         * @return false|string
         */
        protected static function attributeName(string $attribute) {
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
