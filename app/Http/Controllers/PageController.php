<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Page $page
     * @return View
     */
    public function __invoke(Request $request, Page $page): View
    {
        return view('page.show', compact('page'));
    }
}
