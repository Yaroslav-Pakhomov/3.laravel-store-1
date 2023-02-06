<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Basket;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('layouts.site', static function ($view) {
            $view->with(['positions' => Basket::getCount()]);
        });

        // View::composer('layout.part.pages', function($view) {
        //     $view->with(['pages' => Page::all()]);
        // });
    }
}
