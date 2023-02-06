<?php

namespace App\Providers;

use App\Helpers\LocalImageSaver;
use Illuminate\Support\ServiceProvider;

class ImageSaverServiceProvider extends ServiceProvider {
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void {
        /*
        $this->app->bind(ImageSaverContract::class, function () {
            return new LocalImageSaver();
            // return new CloudImageSaver();
        });
        */
        // $this->app->singleton(ImageSaverContract::class, function (Application $app) {
        //     // здесь мы можем заменить реализацию интерфейса ImageSaverContract

        //     // для динамических методов передаём объект ImageResizeMaster()
        //     return new LocalImageSaver($app->make(ImageResizerContract::class));
        //     // return new CloudImageSaver($app->make(ImageResizerContract::class));
        // });


        // 'ImageSaver' - фасад App\Helpers\Facades\ImageSaver
        $this->app->singleton('ImageSaver', function() {
            //Application $app
            // $app->make(ImageResizerContract::class) - можно передать аргумент
            return new LocalImageSaver();
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


    /**
     * В методы singleton() и bind() первым параметром передается название контракта (интерфейса), а вторым
     * параметром — анонимная функция, возвращающая один из классов, реализующих данный интерфейс. Лучше
     * использовать метод singleton() т.к. он создает объект указанного класса только один раз, а при
     * последующих обращениях возвращает тот же объект.
     *
     * Методы singleton() и bind() есть смысл использовать, когда в анонимной функции нужно выполнить дополнительный код. В противном случае можно поступить гораздо проще.
     *
     * public function register() {
     *       App::singleton(ImageSaverContract::class, LocalImageSaver::class);
     *   }
     *
     * public function register() {
     *       App::bind(ImageSaverContract::class, LocalImageSaver::class);
     *   }

     *
     * public $singletons = [
     *       ImageSaverContract::class => LocalImageSaver::class,
     *   ];
     *
     * public $bindings = [
     *       ImageSaverContract::class => LocalImageSaver::class,
     *   ];

     */
}
