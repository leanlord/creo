<?php

    namespace App\Services\Filters;

    use Illuminate\Http\Request;

    class BoolFilter extends BaseFilter
    {
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
            if (!empty($this->filteringValues)) {
                $query->where('is_rented', $this->filteringValues);
            }
        }
    }
