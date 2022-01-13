<?php

    namespace App\Services\Filters;

    use Illuminate\Http\Request;

    class FilterComposite
    {
        use HasAttributes;

        protected array $filters = [];

        public function __construct(Request $request) {
            $this->request = $request;
            NumericFilter::setMinMaxValues();
            if ($this->hasAny(NumericFilter::getFilteringAttributes())) {
                $this->filters[] = new NumericFilter($request);
            }
            if ($this->hasAny(StringFilter::getFilteringAttributes())) {
                $this->filters[] = new StringFilter($request);
            }
            if ($this->hasAny(BoolFilter::getFilteringAttributes())) {
                $this->filters[] = new BoolFilter($request);
            }
        }

        public function filter($query) {
            foreach ($this->filters as $filter) {
                $filter->filter($query);
            }
        }
    }
