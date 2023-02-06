<?php

declare(strict_types=1);

namespace App\Models;

// use App\Helpers\Contracts\ImageResizerContract;
// use App\Helpers\Facades\ImageSaver;
use App\Helpers\LocalImageSaver;
use App\Http\Requests\Category\CategoryCatalogRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use ImageSaver;

// use App\Http\Requests\Category\StoreCategoryRequest;
// use App\Http\Requests\Category\UpdateCategoryRequest;

/**
 * @property mixed $image
 * @property mixed $id
 * @property mixed $children
 * @property mixed $products
 * @property mixed $parent_id
 * @property mixed $name
 * @property mixed $content
 * @property mixed $slug
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    protected $guarded = [];

    private LocalImageSaver $imageSaver;

    /**
     * Путь для формирования пути сохранения изображения
     */
    public const DIR = 'category/';


    public function __construct()
    {
        parent::__construct();
        $this->imageSaver = new LocalImageSaver();
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `products`
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
    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    /**
     * Возвращает список корневых категорий каталога товаров
     */
    public static function parentCategories(): Collection|array
    {
        return self::query()->where('parent_id', 0)->with('children')->orderBy('updated_at', 'DESC')->get();
    }

    /**
     * Создаёт новую категорию
     */
    // public static function storeCategory(StoreCategoryRequest $request, $validated): Category
    public function storeCategory(CategoryCatalogRequest $request, $validated): Category
    {
        $category = new Category();
        $category->parent_id = $validated['parent_id'];
        $category->name = $validated['name'];
        $category->content = $validated['content'];
        $category->slug = $validated['slug'];
        if (!empty($validated['image'])) {
            $category->imageSaver->uploadImage($request, $category, self::DIR);
        }
        $category->save();

        return $category;
    }

    /**
     * Обновляет существующую категорию
     */
    // public static function updateCategory(UpdateCategoryRequest $request, Category $category, $validated): Category
    public static function updateCategory(CategoryCatalogRequest $request, Category $category, $validated): Category
    {
        // dd($validated);
        $category->parent_id = $validated['parent_id'];
        $category->name = $validated['name'];
        $category->content = $validated['content'];
        $category->slug = $validated['slug'];
        // если надо удалить старое изображение
        if (!empty($validated['remove'])) {
            $category->imageSaver->removeImage($category, self::DIR);
        }
        $category->imageSaver->uploadImage($request, $category, self::DIR);
        $category->update();

        return $category;
    }

    /**
     * Проверяет, что переданный идентификатор id может быть родителем
     * этой категории; что категорию не пытаются поместить внутрь себя
     */
    public function validParent($id): bool
    {
        $id = (int)$id;
        // получаем идентификаторы всех потомков текущей категории
        $ids = self::getAllChildren($this->id);
        $ids[] = $this->id;

        return !in_array($id, $ids, FALSE);
    }

    /**
     * Возвращает всех потомков категории с идентификатором $id
     */
    public static function getAllChildren(int $id): array
    {
        // получаем прямых потомков категории с идентификатором $id
        $children = self::query()->where('parent_id', $id)->with('children')->get();
        $ids = [];
        $arr_children = [];
        foreach ($children as $child) {
            $ids[] = $child->id;
            // для каждого прямого потомка получаем его прямых потомков
            if ($child->children->count()) {
                $arr_children[] = self::getAllChildren($child->id);
            }
        }

        return array_merge($ids, $arr_children);
    }

    /**
     * Связь «один ко многим» таблицы `categories` с таблицей `categories`, но
     * позволяет получить не только дочерние категории, но и дочерние-дочерние
     */
    public function descendants(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id')->with('descendants');
    }

    /**
     * Возвращает список всех категорий каталога в виде дерева
     */
    public static function hierarchy(): Collection|array
    {
        return self::query()->where('parent_id', 0)->with('descendants')->get();
    }
}
