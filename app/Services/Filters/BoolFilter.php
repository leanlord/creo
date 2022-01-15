<?php

    namespace App\Services\Filters;

    class BoolFilter extends AbstractFilter
    {
        /**
         * @var array|string[]
         */
        protected static array $filteringAttributes = ['is_rented'];

        public function setFilteringValues(): void {
            if ($this->has('is_rented')) {
                if ($this->request->get('is_rented') == 'Сдан') {
                    $this->filteringValues = true;
                } else {
                    $this->filteringValues = false;
                }
            }
        }

        public function filter($query): void {
            $query->where('is_rented', $this->filteringValues);
        }

        /**
         * @return array|string[]
         */
        public static function getFilteringAttributes(): array {
            return static::$filteringAttributes;
        }
    }
