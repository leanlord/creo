<?php

    namespace App\Services\Filters;

    trait HasAttributes
    {
        /**
         * Determines, if attribute are needed
         *
         * @param string $attribute
         * @return bool
         */
        protected function has(string $attribute): bool {
            return !($this->request->get($attribute) == null ||
                $this->request->get($attribute) == 'Любой');
        }

        /**
         * Determines, if at list one of attributes are needed
         *
         * @param array $attributes
         * @return bool
         */
        protected function hasAny(array $attributes): bool {
            foreach ($attributes as $attribute) {
                if ($this->has($attribute)) {
                    return true;
                }
            }

            return false;
        }
    }
