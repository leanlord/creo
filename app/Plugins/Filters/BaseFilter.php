<?php

namespace App\Plugins\Filters;

use Illuminate\Http\Request;

abstract class BaseFilter
{
    /**
     *
     *
     * @var array
     */
    protected $filteringValues;

    public function __construct($request)
    {
        $this->filteringValues = static::getFilteringValues($request);
    }

    abstract public static function getFilteringValues(Request $request): array;

    abstract public function filter($query);
}
