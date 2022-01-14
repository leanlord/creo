<?php

namespace App\Providers;

use App\Services\Filters\Filter;
use App\Services\Filters\FilterComposite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        Filter::class => FilterComposite::class
    ];
}
