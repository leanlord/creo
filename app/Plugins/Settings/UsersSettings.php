<?php

namespace App\Plugins\Settings;

class UsersSettings
{
    /**
     * @var string[]
     */
    protected static $attributes = [
        'first_name',
        'last_name',
        'number',
        'email',
        'password',
    ];

    /**
     * @return string[]
     */
    public static function getAttributes(): array
    {
        return self::$attributes;
    }
}
