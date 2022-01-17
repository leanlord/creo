<?php

namespace App\Providers;

use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\HomepageController;
use App\Services\Filters\Filter;
use App\Services\Filters\FilterComposite;
use App\Services\Mailers\Mailer;
use App\Services\Mailers\VerifyMailer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        Filter::class => FilterComposite::class,
    ];

    public function register() {
        $this->app->when(EmailVerifyController::class)
            ->needs(Mailer::class)
            ->give(VerifyMailer::class);
    }
}
