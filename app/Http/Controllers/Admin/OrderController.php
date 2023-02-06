<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $orders = Order::query()->orderBy('created_at', 'desc')->paginate(5);
        $statuses = Order::STATUSES;

        return view('admin.order.index', compact('orders', 'statuses'));
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return View
     */
    public function show(Order $order): View
    {
        $statuses = Order::STATUSES;
        return view('admin.order.show', compact('order', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return View
     */
    public function edit(Order $order): View
    {
        $statuses = Order::STATUSES;
        return view('admin.order.edit', compact('order', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order   $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update($request->all());
        return redirect()->route('admin.order.show', [ 'order' => $order->id ])->with('success', 'Заказ был успешно обновлен');
    }
}
