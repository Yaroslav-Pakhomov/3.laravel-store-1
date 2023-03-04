<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request): View
    {
        $new = Product::whereNew(true)->latest('updated_at')->limit(3)->get();
        $hit = Product::whereHit(true)->latest('updated_at')->limit(3)->get();
        $sale = Product::whereSale(true)->latest('updated_at')->limit(3)->get();

        return view('index', compact('new', 'hit', 'sale'));
    }
}
