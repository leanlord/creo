<?php

namespace App\Plugins\Filters;

use Illuminate\Http\Request;

abstract class BaseFilter
{
    /**
     * Concrete values which will be used for filtering
     * @var array
     */
    public $filteringValues;

    public function __construct($request)
    {
        $this->filteringValues = static::getFilteringValues($request);
    }

    /**
     * Defines, how filtering values will be
     * converted from get request to concrete values
     *
     * @param Request $request
     * @return array
     */
    abstract public static function getFilteringValues(Request $request): array;

    /**
     * Adding conditions to filter set of values
     *
     * @param $query
     * @return void
     */
    abstract public function filter($query): void;
}
