<?php

namespace App\Services\Uploaders;

interface Uploader
{
    public function load();

    public function save();

    public function delete();

    public function hasOld(): bool;

    public function getOld();

    public function makeFilename();

    public function getFilename(): string;
}
