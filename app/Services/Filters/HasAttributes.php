<?php

    namespace App\Services\Filters;

    use Illuminate\Http\Request;

    trait HasAttributes
    {
        protected Request $request;

        protected function has(string $attribute): bool {
            return !($this->request->get($attribute) == null ||
                $this->request->get($attribute) == 'Любой');
        }

        protected function hasAny(array $attributes): bool {
            foreach ($attributes as $attribute) {
                if ($this->has($attribute)) {
                    return true;
                }
            }

            return false;
        }
    }
