<?php

namespace App\Services\Settings;

class UsersSettings
{
    /**
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
