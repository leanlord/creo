<?php

namespace App\Plugins\Settings;

class FlatsSettings
{
    /**
     * Attributes to filter with 'like' operator
     *
     * @var string[]
     */
    protected static $stringFilteringAttributes = [
        'city',
        'company',
        'area'
    ];

    /**
     * Numeric filtering attributes for
     * "between" queries
     *
     * @var string[]
     */
    protected static $intFilteringAttributes = ['price', 'square'];

    /**
     * List of all related tables, key is the name of
     * table, value is the communication field
     *
     * @var string[]
     */
    protected static $relatedTables = [
        'cities',
        'companies',
        'areas'
    ];

    protected static $communicationFields = [
        'city_id',
        'company_id',
        'area_id'
    ];

    /**
     * Attributes, which can be counted
     *
     * @var array
     */
    protected static $countableAttributes = [];

    /**
     * Attributes that will be returned to frontend
     *
     * @var string[]
     */
    protected static $flatsAttributes = [
        'address',
        'square',
        'is_rented',
        'price',
        'city',
        'company',
        'area'
    ];

    /**
     * @return string[]
     */
    public static function getStringFilteringAttributes(): array
    {
        return array_combine(self::$relatedTables, self::$stringFilteringAttributes);
    }

    /**
     * @return string[]
     */
    public static function getIntFilteringAttributes(): array
    {
        return self::$intFilteringAttributes;
    }

    /**
     * @return string[]
     */
    public static function getRelatedTables(): array
    {
        return array_combine(self::$relatedTables, self::$communicationFields);
    }

    /**
     * @return int
     */
    public static function getCountOfStringAttributes(): int
    {
        return count(self::$stringFilteringAttributes);
    }

    public static function getCountOfNumericAttributes(): int
    {
        return count(static::$intFilteringAttributes);
    }

    /**
     * @return string[]
     */
    public static function getFlatsAttributes(): array
    {
        return self::$flatsAttributes;
    }
}
