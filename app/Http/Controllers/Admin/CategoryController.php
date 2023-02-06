<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryCatalogRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class CategoryController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = Category::hierarchy();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        // для возможности выбора родителя
        $parentCategories = Category::hierarchy();

        return view('admin.category.create', compact('parentCategories'));
    }

    /**
     * @param CategoryCatalogRequest $request
     * @return RedirectResponse
     */
    // public function store(StoreCategoryRequest $request): RedirectResponse
    public function store(CategoryCatalogRequest $request): RedirectResponse
    {
        $category = new Category();
        $validated = $request->validated();
        $category = $category->storeCategory($request, $validated);

        return redirect()->route('admin.category.show', [ $category->id ])->with('success',
                                                                                 'Новая категория успешно создана');
    }

    /**
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        // для возможности выбора родителя
        $parentCategories = Category::hierarchy();

        return view('admin.category.edit', compact('category', 'parentCategories'));
    }

    /**
     * @param CategoryCatalogRequest $request
     * @param Category               $category
     * @return RedirectResponse
     */
    // public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    public function update(CategoryCatalogRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();
        $category = Category::updateCategory($request, $category, $validated);

        return redirect()->route('admin.category.show', [ $category->id ])->with('success',
                                                                                 'Категория была успешно исправлена');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     */
    public function delete(Category $category): RedirectResponse
    {
        if ($category->children->count()) {
            $errors[] = 'Нельзя удалить категорию с дочерними категориями.';
        }

        if ($category->products->count()) {
            $errors[] = 'Нельзя удалить категорию, которая содержит товары.';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Категория каталога успешно удалена');
    }
}
