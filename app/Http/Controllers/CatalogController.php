<?php

declare(strict_types=1);

namespace App\Http\Controllers;

// use App\Helpers\ProductFilter;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class CatalogController extends Controller
{
    public function index(): View
    {
        // корневые категории
        $categories = Category::parentCategories();
        // $brands = Brand::query()->get();
        // популярные бренды
        $brands = Brand::popular();

        return view('catalog.index', compact('categories', 'brands'));
    }

    public function category(Request $request, Category $category): View
    {
        $category->id = (int)$category->id;
        /**
         * Получаем товары категории и ее потомков применяем
         * фильтры получаем продукты с применением фильтров
         * по 6 продуктов на страницу
         */
        $products = Product::categoryProducts($category->id)->filterProducts($request)->paginate(6)->withQueryString();

        return view('catalog.category', compact('category', 'products'));
    }

    public function brand(Request $request, Brand $brand): View
    {
        // products() - возвращает построитель запроса
        $products = $brand->products()->filterProducts($request)->paginate(6)->withQueryString();
        // $products = $brand->products()->paginate(6);

        return view('catalog.brand', compact('brand', 'products'));
    }

    public function product(Product $product): View
    {
        return view('catalog.product', compact('product'));
    }

    public function search(Request $request): View
    {
        $search = $request->input('query');
        $query = Product::search($search);
        $products = $query->paginate(6)->withQueryString();

        return view('catalog.search', compact('products', 'search'));
    }
}
