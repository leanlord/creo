<?php

namespace App\Services\Filters;

use App\Services\Settings\FlatsSettings;
use Illuminate\Http\Request;

abstract class BaseFilter
{
    /**
     * Concrete values which will be used for filtering
     * @var array
     */
    protected array $filteringValues = [];

    protected FlatsSettings $settings;

    public function __construct(Request $request)
    {
        $this->setFilteringValues($request);
        $this->settings = new FlatsSettings();
    }

    /**
     * Defines, how filtering values will be
     * converted from get request to concrete values
     *
     * @param Request $request
     */
    abstract public function setFilteringValues(Request $request): void;

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
