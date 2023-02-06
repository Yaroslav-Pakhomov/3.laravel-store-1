<?php

namespace App\Providers;

use App\Helpers\Contracts\ImageResizerContract;
// use App\Helpers\Contracts\ImageResizerContract;
use App\Helpers\ImageResizeMaster;
use Illuminate\Support\ServiceProvider;

class ImageResizerServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageResizerContract::class, function () {
            // здесь мы можем заменить реализацию интерфейса ImageResizerContract

            return new ImageResizeMaster();
            // return new ImageResizeWizard();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
