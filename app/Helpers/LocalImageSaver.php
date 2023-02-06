<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Helpers\Contracts\ImageSaverContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

/*
 * Это первая реализация интерфейса ImageSaverContract
 */

class LocalImageSaver implements ImageSaverContract
{

    /**
     * Путь к изображениям
     */
    public const PATH = 'public/images/';

    /**
     * Путь к изначальному изображению
     */
    public const PATH_ORIGIN = '/origin/';

    /**
     * Путь к полному масштабированному изображению
     */
    public const PATH_FULL = '/full/';

    /**
     * Путь к масштабированному изображению анонса
     */
    public const PATH_SHORT = '/short/';

    /**
     * Загрузка изображения при создании поста
     *
     * @param object $request — объект HTTP-запроса
     * @param object $model — модель категории, бренда или товара
     * @param string $dir — директория, куда будем сохранять изображение
     * @return void
     */
    public static function uploadImage(object $request, object $model, string $dir): void
    {
        $dir_origin = self::PATH . $dir . self::PATH_ORIGIN;
        $dir_full = self::PATH . $dir . self::PATH_FULL;
        $dir_short = self::PATH . $dir . self::PATH_SHORT;

        // если было загружено новое изображение
        $orig_img = $request->file('image');

        if ($orig_img) {
            // уникальное имя файла
            $name = md5(Carbon::now() . '_' . $orig_img->getClientOriginalName());
            // расширение файла
            $ext = $orig_img->getClientOriginalExtension();

            // сохраним его в storage/images/original
            Storage::putFileAs($dir_origin, $orig_img, $name . '.' . $ext);

            //---------------------------------------------
            // Основное изображение - начало
            // Размер 1200x400
            //---------------------------------------------
            // создаем jpg изображение для списка постов блога размером 1200x400, качество 100%
            $full_image = ImageResizeMaster::setResizeImage($orig_img, 1200, 400);
            // сохраняем это изображение под именем $name.jpg в директории public/images/images
            Storage::put($dir_full . $name . '.jpg', $full_image);
            $full_image->destroy();
            // записываем путь в БД
            $model->full_image = Storage::url($dir_full . $name . '.jpg');
            //---------------------------------------------
            // Основное изображение - конец
            //---------------------------------------------

            //---------------------------------------------
            // Анонс изображение - начало
            // Размер 600x200
            //---------------------------------------------
            // создаем jpg изображение для списка постов блога размером 600x200, качество 100%
            $preview_image = ImageResizeMaster::setResizeImage($orig_img, 600, 200);
            // сохраняем это изображение под именем $name.jpg в директории public/img/thumb
            Storage::put($dir_short . $name . '.jpg', $preview_image);
            $preview_image->destroy();
            // записываем путь в БД
            $model->preview_image = Storage::url($dir_short . $name . '.jpg');
            //---------------------------------------------
            // Анонс изображение - конец
            //---------------------------------------------

            // $model->preview_image = Storage::url('public/images/original/' . $name . '.' . $ext);
            // $model->img = Storage::url('public/images/original/' . $name . '.' . $ext);
            // dd($model);
        }
    }

    /**
     * Удаление изображения при обновлении и удалении поста
     *
     * @param object $model — модель категории, бренда или товара
     * @param string $dir — директория, куда будем сохранять изображение
     * @return void
     */
    public static function removeImage(object $model, string $dir): void
    {
        // $dir_origin = self::PATH.$dir.self::PATH_ORIGIN;
        $dir_full = self::PATH . $dir . self::PATH_FULL;
        $dir_short = self::PATH . $dir . self::PATH_SHORT;

        // Основное изображение
        if (!empty($model->full_image)) {
            $name = basename($model->full_image);
            if (Storage::exists($dir_full . $name)) {
                Storage::delete($dir_full . $name);
            }
            $model->full_image = NULL;
        }
        // Анонс-изображение
        if (!empty($model->preview_image)) {
            $name = basename($model->preview_image);
            if (Storage::exists($dir_short . $name)) {
                Storage::delete($dir_short . $name);
            }
            $model->preview_image = NULL;
        }

        if (!empty($name)) {
            // Все изображения директорий
            // $images = Storage::files($dir_origin);
            $images = Storage::files(self::PATH);

            // берём имя файла без расширения
            $base = pathinfo($name, PATHINFO_FILENAME);

            foreach ($images as $img) {
                $temp = pathinfo($img, PATHINFO_FILENAME);
                if ($temp === $base) {
                    Storage::delete($img);
                    break;
                }
            }
        }
    }

}
