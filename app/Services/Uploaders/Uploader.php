<?php

namespace App\Services\Uploaders;

interface Uploader
{
    public function load();

    public function save(string $prefix);

    public function deleteFor($user, string $prefix = '');

    public function hasOld(): bool;

    public function getOld();

    public function getFilename(): string;
}
