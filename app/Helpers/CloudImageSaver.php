<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Contracts\ImageSaverContract;

/*
 * Это вторая реализация интерфейса ImageSaverContract
 */

class CloudImageSaver implements ImageSaverContract {

    public static function uploadImage(object $request, object $model, $dir): void {
        echo 'Файл был сохранен на удаленном сервере';
    }

    public static function removeImage(object $model, string $dir): void {
        echo 'Файл был удален на удаленном сервере';
    }
}
