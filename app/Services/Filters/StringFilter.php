<?php

    namespace App\Services\Filters;

    class StringFilter extends AbstractFilter
    {
        /**
         * Attributes to filter with "like" operator
         *
         * @var string[]
         */
        protected static array $filteringAttributes = [
            'city',
            'company',
            'area',
        ];

        /**
         * Returns attributes and tables in which they are located
         *
         * @return string[]
         */
        public function getFilteringColumns(): array {
            return array_combine(
                $this->settings->getRelatedTablesNames(),
                static::$filteringAttributes
            );
        }

        /**
         * Обработка всех строковых параметров запроса.
         * Если GET параметр существует, то задается
         * значение этого параметра, которое будет использовано
         * как условие в запросе к БД.
         * Иначе, задается "любое значение".
         * (в SQL '%' означает "последовательность любых символов любой длины")
         *
         */
        public function setFilteringValues(): void {
            foreach (static::$filteringAttributes as $stringAttribute) {
                if ($this->has($stringAttribute)) {
                    $this->filteringValues[$stringAttribute] =
                        $this->request->get($stringAttribute);
                } else {
                    $this->filteringValues[$stringAttribute] = '%';
                }
            }
        }

        /**
         * Добавление условия на все строковые аттрибуты
         *
         * @param $query
         */
        public function filter($query): void {
            foreach ($this->getFilteringColumns() as $table => $attribute) {
                $query->where($table . '.name', 'like', $this->filteringValues[$attribute]);
            }
        }

        /**
         * @return string[]
         */
        public static function getFilteringAttributes(): array {
            return self::$filteringAttributes;
        }
    }
