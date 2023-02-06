<?php

declare(strict_types=1);

namespace App\Helpers\Contracts;

interface ImageSaverContract {


    public static function uploadImage(object $request, object $model, string $dir): void;

    public static function removeImage(object $model, string $dir): void;
}
