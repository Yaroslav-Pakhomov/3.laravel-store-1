<?php

declare(strict_types=1);

namespace App\Helpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method removeImage(object $model, string $DIR)
 * @method uploadImage(object $request, object $model, string $DIR)
 */
class ImageSaver extends Facade {

    /**
     * Получение зарегистрированное имя компонента. Для Поставщика Услуг (Service Provider)
     * App\Providers\ImageSaverServiceProvider
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'ImageSaver';
    }

    /**
     * Класс фасада должен наследоваться от родительского класса Illuminate\Support\Facades\Facade и
     * переопределять метод getFacadeAccessor(). Данный метод должен возвращать ключ (строку), к которому
     * привязывается класс в сервис-провайдере. Ключ может быть абсолютно любой строкой, при работе с фасадом
     * обращаться нужно не к нему, а к алиасу.
     */
}
