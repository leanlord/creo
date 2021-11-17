<?php

namespace App\Plugins\Settings;

class FlatsSettings
{
    /**
     * @var string[]
     */
    protected static $stringFilteringAttributes = [
        'cities' => 'city',
        'companies' => 'company',
        'areas' => 'area',
    ];

    /**
     * List of all related tables, key is the name of
     * table, value is the communication field
     *
     * @var string[]
     */
    protected static $relatedTables = [
        'cities' => 'city_id',
        'companies' => 'company_id',
        'areas' => 'area_id'
    ];

    /**
     * Attributes, which can be counted
     *
     * @var array
     */
    protected static $countableAttributes = [];

    /**
     * Numeric filtering attributes for
     * "between" queries
     *
     * @var string[]
     */
    protected static $intFilteringAttributes = ['price', 'square'];

    /**
     * @return string[]
     */
    public static function getStringFilteringAttributes(): array
    {
        return self::$stringFilteringAttributes;
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
        return self::$relatedTables;
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
}
