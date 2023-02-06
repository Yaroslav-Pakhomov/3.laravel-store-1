<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;

/**
 * @property mixed $id
 */
class Page extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pages';

    protected $fillable = [
        'name',
        'slug',
        'content',
        'parent_id',
    ];
    // protected $guarded = [];

    /**
     * Связь «один ко многим» таблицы `pages` с таблицей `pages`
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    /**
     * Связь «страница принадлежит» таблицы `pages` с таблицей `pages`
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__);
    }

    /**
     * Если мы в панели управления — страница будет получена из
     * БД по id, если в публичной части сайта — то по slug
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        $current = Route::currentRouteName();
        if ('page.show' === $current) {
            return 'slug'; // мы в публичной части сайта
        }
        return 'id'; // мы в панели управления
    }
}
