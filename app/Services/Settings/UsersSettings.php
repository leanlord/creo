<?php

namespace App\Services\Settings;

class UsersSettings
{
    /**
     * Columns in users table
     *
     * @var string[]
     */
    protected array $attributes = [
        'first_name',
        'last_name',
        'number',
        'email',
    ];

    /**
     * @return string[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
