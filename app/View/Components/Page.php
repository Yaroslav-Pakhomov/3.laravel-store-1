<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\Page as ModelsPage;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Page extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|\Closure|string
     */
    public function render(): View|\Closure|string
    {
        $pages = ModelsPage::all();

        return view('components.page', compact('pages'));
    }
}
