<?php

declare(strict_types=1);

namespace App\Models;

use App\Helpers\ProductFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stem\LinguaStemRu;

/**
 * @property mixed $id
 * @method static categoryProducts(mixed $id)
 * @method static search(mixed $search)
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $guarded = [];

    /**
     * Связь «товар принадлежит» таблицы `products` с таблицей `categories`
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Связь «товар принадлежит» таблицы `products` с таблицей `brands`
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Связь «многие ко многим» таблицы `products` с таблицей `baskets`
     *
     * @return BelongsToMany
     */
    public function baskets(): BelongsToMany
    {
        return $this->belongsToMany(Basket::class)->withPivot('quantity');
    }



    /**
     * Скоупы (Scopes) - начало
     */

    /**
     * Позволяет выбирать товары категории и всех ее потомков
     *
     * @param Builder $builder
     * @param int     $id
     * @return Builder
     */
    public function scopeCategoryProducts(Builder $builder, int $id): Builder
    {
        // получаем всех потомков этой категории
        $descendants = Category::getAllChildren($id);
        $descendants[] = $id;

        // получаем товары категории и ее потомков, потом применяем фильтры
        return $builder->whereIn('category_id', $descendants);
    }

    /**
     * Позволяет фильтровать товары по нескольким условиям
     *
     * @param Builder $builder
     * @param Request $request
     * @return Builder
     */
    public function scopeFilterProducts(Builder $builder, Request $request): Builder
    {
        return (new ProductFilter($builder, $request))->apply();
    }

    /**
     * Позволяет искать товары по заданным словам
     *
     * @param Builder $query
     * @param string  $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        // обрезаем поисковый запрос
        $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        $search = preg_replace('#[^0-9a-zA-ZА-яёЁ]#u', ' ', $search);
        // сжимаем двойные пробелы
        $search = preg_replace('#\s+#u', ' ', $search);
        $search = trim($search);
        if (empty($search)) {
            // возвращаем пустой результат
            return $query->whereNull('id');
        }

        // разбиваем поисковый запрос на отдельные слова
        $temp = explode(' ', $search);
        $words = [];
        $stemmer = new LinguaStemRu();

        foreach ($temp as $item) {
            if (iconv_strlen($item) > 3) {
                // получаем корень слова
                $words[] = $stemmer->stem_word($item);
            } else {
                $words[] = $item;
            }
        }

        // релевантность — у названия товара и описания товара больше, у названия категории и названия бренда меньше.
        $relevance = "IF (`products`.`name` LIKE '%" . $words[0] . "%', 2, 0)";
        $relevance .= " + IF (`products`.`content` LIKE '%" . $words[0] . "%', 1, 0)";
        $relevance .= " + IF (`categories`.`name` LIKE '%" . $words[0] . "%', 1, 0)";
        $relevance .= " + IF (`brands`.`name` LIKE '%" . $words[0] . "%', 2, 0)";
        for ($i = 1, $iMax = count($words); $i < $iMax; $i++) {
            $relevance .= " + IF (`products`.`name` LIKE '%" . $words[ $i ] . "%', 2, 0)";
            $relevance .= " + IF (`products`.`content` LIKE '%" . $words[ $i ] . "%', 1, 0)";
            $relevance .= " + IF (`categories`.`name` LIKE '%" . $words[ $i ] . "%', 1, 0)";
            $relevance .= " + IF (`brands`.`name` LIKE '%" . $words[ $i ] . "%', 2, 0)";
        }

        // Ищем по полям name (название товара), content (описание товара) таблицы products, name (название категории) таблицы categories, name (название бренда) таблицы brands
        $query->join('categories', 'categories.id', '=', 'products.category_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select('products.*', DB::raw($relevance . ' as relevance'))
            ->where('products.name', 'like', '%' . $words[0] . '%')
            ->orWhere('products.content', 'like', '%' . $words[0] . '%')
            ->orWhere('categories.name', 'like', '%' . $words[0] . '%')
            ->orWhere('brands.name', 'like', '%' . $words[0] . '%');
        for ($i = 1, $iMax = count($words); $i < $iMax; $i++) {
            $query = $query->orWhere('products.name', 'like', '%' . $words[ $i ] . '%');
            $query = $query->orWhere('products.content', 'like', '%' . $words[ $i ] . '%');
            $query = $query->orWhere('categories.name', 'like', '%' . $words[ $i ] . '%');
            $query = $query->orWhere('brands.name', 'like', '%' . $words[ $i ] . '%');
        }
        $query->orderBy('relevance', 'desc');


        return $query;
    }

    /**
     * Скоупы (Scopes) - конец
     */

}
