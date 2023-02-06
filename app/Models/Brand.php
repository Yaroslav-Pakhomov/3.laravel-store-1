<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static get()
 * @property mixed $products
 * @property mixed $id
 */
class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'brands';

    protected $guarded = [];

    /**
     * Связь «один ко многим» таблицы `brands` с таблицей `products`
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`
     */
    // public function children() {
    //     return $this->hasMany(Brand::class, 'parent_id');
    // }

    /**
     * Получаем последние 3 бренда по полю обновления
     */
    public static function popular(): Collection|array
    {
        return self::query()->latest('updated_at')->limit(3)->get();
    }


}
