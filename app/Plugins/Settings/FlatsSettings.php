<?php

namespace App\Plugins\Settings;

class FlatsSettings
{
    /**
     * List of all related tables
     *
     * @var string[]
     */
    protected static $relatedTables = [
        'cities',
        'companies',
        'areas'
    ];

    /**
     * Columns that are used for tables communication
     *
     * @var string[]
     */
    protected static $communicationColumns = [
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
     * Attributes that will be returned to view
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
     * Returns related tables as keys
     * and communication columns as values
     *
     * @return string[]
     */
    public static function getRelatedTables(): array
    {
        return array_combine(self::$relatedTables, self::$communicationColumns);
    }

    public static function getRelatedTablesNames(): array
    {
        return self::$relatedTables;
    }

    public static function getFlatsAttributes(): array
    {
        return self::$flatsAttributes;
    }
}
