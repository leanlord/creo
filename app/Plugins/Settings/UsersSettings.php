<?php

namespace App\Plugins\Settings;

class UsersSettings
{
    /**
     * @var string[]
     */
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
    public static function getUserAttributes(): array
    {
        return self::$userAttributes;
    }
}
