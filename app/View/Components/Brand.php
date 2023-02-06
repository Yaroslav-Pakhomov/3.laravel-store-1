<?php

namespace App\View\Components;

use App\Models\Brand as ModelsBrand;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Brand extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render()
    {
        $brands = ModelsBrand::withCount('products')->orderbyDesc('products_count')->limit(3)->get();

        return view('components.brand', compact('brands'));
    }
}
