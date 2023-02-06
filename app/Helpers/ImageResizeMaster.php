<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Contracts\ImageResizerContract;
use Intervention\Image\Facades\Image as ImageFacade;
use Intervention\Image\Image;

class ImageResizeMaster implements ImageResizerContract {

    /**
     * @param object $orig_img
     * @param int    $width
     * @param int    $height
     * @return Image
     */
    public static function setResizeImage(object $orig_img, int $width, int $height): Image
    {
        $image = ImageFacade::make($orig_img);
        $resizeHeight = $image->height();
        $resizeWidth = $image->width();

        // Размер width x height
        if ($resizeWidth > $width && $resizeHeight > $height) {
            // Изменяет размер изображения так, чтобы самая большая сторона соответствовала ограничению; меньшая сторона будет масштабирована для сохранения исходного соотношения сторон
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } else {
            // Изменяет размер границ текущего изображения на заданную ширину и высоту, фоновый цвет чёрный
            $image->resizeCanvas($width, $height, 'center', FALSE, '000000');
        }

        // Кодируем текущее изображение в jpg, качество 100%
        return $image->encode('jpg', 100);
    }
}
