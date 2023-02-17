<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Facades\ImageSaver;
// use ImageSaver;
// use App\Helpers\LocalImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\BrandCatalogRequest;
use App\Models\Brand;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BrandController extends Controller
{
    private ImageSaver $imageSaver;

    public function __construct(ImageSaver $imageSaver)
    {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $brands = Brand::query()->get();
        return view('admin.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandCatalogRequest $request
     * @return RedirectResponse
     */
    public function store(BrandCatalogRequest $request): RedirectResponse
    {
        $brand = new Brand();
        $data = $request->all();
        $data['image'] = $this->imageSaver->uploadImage($request, $brand, 'brand');
        $data['full_image'] = $brand['full_image'];
        $data['preview_image'] = $brand['preview_image'];
        unset($data['image']);
        $brand = Brand::query()->create($data);

        return redirect()->route('admin.brand.show', [ $brand->id ])->with('success', 'Новый бренд успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brand
     * @return View
     */
    public function show(Brand $brand): View
    {
        return view('admin.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return View
     */
    public function edit(Brand $brand): View
    {
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandCatalogRequest $request
     * @param Brand               $brand
     * @return RedirectResponse
     */
    public function update(BrandCatalogRequest $request, Brand $brand): RedirectResponse
    {
        $data = $request->all();
        $data['image'] = $this->imageSaver->uploadImage($request, $brand, 'brand');
        unset($data['image']);
        $brand->update($data);

        return redirect()->route('admin.brand.show', [ $brand->id ])->with('success',
                                                                           'Бренд был успешно отредактирован');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function delete(Brand $brand): RedirectResponse
    {
        if ($brand->products->count()) {
            return back()->withErrors('Нельзя удалить бренд, у которого есть товары');
        }
        $this->imageSaver->removeImage($brand, 'brand');
        $brand->delete();
        return redirect()->route('admin.brand.index')->with('success', 'Бренд каталога успешно удален');
    }

}
