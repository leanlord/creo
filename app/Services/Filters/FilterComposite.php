<?php

    namespace App\Services\Filters;

    use Illuminate\Http\Request;

    /**
     * Used "Composite" design pattern.
     * If user's request some parameters,
     * concrete filter will be created.
     */
    class FilterComposite implements Filter
    {
        use HasAttributes;

        protected array $filters = [];

        public function __construct(Request $request) {
            $this->request = $request;

            //This action is needed, because min and max values
            //must always be calculated.
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

        /*
        * @param $query
        */
        public function filter($query) {
            foreach ($this->filters as $filter) {
                $filter->filter($query);
            }
        }
    }
