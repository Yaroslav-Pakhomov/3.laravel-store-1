<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Facades\ImageSaver;
// use ImageSaver;
// use App\Helpers\LocalImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCatalogRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Путь для формирования пути сохранения изображения
     */
    public const DIR = '/product/';

    private ImageSaver $imageSaver;

    public function __construct(ImageSaver $imageSaver)
    {
        $this->imageSaver = $imageSaver;
    }


    /**
     * Показывает список всех товаров каталога
     *
     * @return View
     */
    public function index(): View
    {
        // корневые категории для возможности навигации
        $roots = Category::query()->where('parent_id', 0)->get();
        $products = Product::query()->paginate(5);

        return view('admin.product.index', compact('products', 'roots'));
    }

    /**
     * Показывает форму для создания товара
     *
     * @return View
     */
    public function create(): View
    {
        // все категории для возможности выбора
        $categories = Category::all();
        // все бренды для возможности выбора подходящего
        $brands = Brand::all();

        return view('admin.product.create', compact('categories', 'brands'));
    }

    /**
     * Сохраняет новый товар в базу данных
     *
     * @param ProductCatalogRequest $request
     * @return RedirectResponse
     */
    public function store(ProductCatalogRequest $request): RedirectResponse
    {
        $request->merge([
                            'new'  => $request->has('new'),
                            'hit'  => $request->has('hit'),
                            'sale' => $request->has('sale'),
                        ]);
        $data = $request->all();
        $data['image'] = $this->imageSaver->uploadImage($request, NULL, 'product');
        // $data['full_image'] = $brand['full_image'];
        // $data['preview_image'] = $brand['preview_image'];
        // unset($data['image']);
        $product = Product::query()->create($data);

        return redirect()->route('admin.product.show', [ $product->id ])->with('success', 'Новый товар успешно создан');
    }

    /**
     * Показывает страницу товара каталога
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Показывает форму для редактирования товара
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        // все категории для возможности выбора
        // $categories = Category::all()->toArray();
        $categories = Category::all();
        // все бренды для возможности выбора подходящего
        $brands = Brand::all();
        // dd($categories);

        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Обновляет товар каталога в базе данных
     *
     * @param ProductCatalogRequest $request
     * @param Product               $product
     * @return RedirectResponse
     */
    public function update(ProductCatalogRequest $request, Product $product): RedirectResponse
    {
        $request->merge([
                            'new'  => $request->has('new'),
                            'hit'  => $request->has('hit'),
                            'sale' => $request->has('sale'),
                        ]);
        $data = $request->all();
        $data['image'] = $this->imageSaver->uploadImage($request, $product, self::DIR);
        unset($data['image']);
        $product->update($data);

        return redirect()->route('admin.product.show', [ $product->id ])->with('success', 'Товар успешно отредактирован');
    }

    /**
     * Удаляет товар каталога из базы данных
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function delete(Product $product): RedirectResponse
    {
        $this->imageSaver->remove($product, self::DIR);
        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Товар каталога успешно удалён');
    }

    /**
     * Показывает товары выбранной категории
     *
     * @param Category $category
     * @return View
     */
    public function category(Category $category): View
    {
        $products = $category->products()->paginate(5);
        return view('admin.product.category', compact('category', 'products'));
    }
}
