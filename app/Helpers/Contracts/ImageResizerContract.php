<?php

declare(strict_types=1);

namespace App\Helpers\Contracts;

use Intervention\Image\Image;

interface ImageResizerContract {

    public static function setResizeImage(object $orig_img, int $width, int $height): Image;
}
