<?php

namespace App\Providers;

use App\Http\Controllers\AvatarUploadController;
use App\Http\Controllers\EmailVerifyController;
use App\Http\Controllers\HomepageController;
use App\Services\Filters\Filter;
use App\Services\Filters\FilterComposite;
use App\Services\Mailers\Mailer;
use App\Services\Mailers\VerifyMailer;
use App\Services\Uploaders\PublicUploader;
use App\Services\Uploaders\Uploader;
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

        $this->app->when(AvatarUploadController::class)
            ->needs(Uploader::class)
            ->give(PublicUploader::class);
    }
}
