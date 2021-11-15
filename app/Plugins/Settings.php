<?php

namespace App\Plugins;

class Settings
{
    /**
     * String filtering attributes - like name, city or color
     *
     * @var string[]
     */
    protected static $stringFilteringAttributes = [
        'city',
        'company',
        'area',
    ];
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
     * Numeric filtering attributes - like min_price, count or horse powers
     *
     * @var string[]
     */
    protected static $intFilteringAttributes = [
        'min_price',
        'max_price',
        'min_square',
        'max_square'
    ];

    protected static $userAttributes = [
        'first_name',
        'last_name',
        'number',
        'email',
        'password',
    ];

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
    public static function getUserAttributes(): array
    {
        return self::$userAttributes;
    }
}
