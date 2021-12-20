<?php

namespace App\Plugins\Filters;

use Illuminate\Http\Request;

abstract class BaseFilter
{
    /**
     * Concrete values which will be used for filtering
     * @var array
     */
    protected $filteringValues;

    public function __construct($request)
    {
        $this->filteringValues = $this->setFilteringValues($request);
    }

    /**
     * Defines, how filtering values will be
     * converted from get request to concrete values
     *
     * @param Request $request
     * @return array
     */
    abstract public function setFilteringValues(Request $request): array;

    /**
     * Adding conditions to filter set of values
     *
     * @param $query
     * @return void
     */
    abstract public function filter($query): void;

    /**
     * @return array
     */
    public function getFilteringValues(): array {
        return $this->filteringValues;
    }
}
