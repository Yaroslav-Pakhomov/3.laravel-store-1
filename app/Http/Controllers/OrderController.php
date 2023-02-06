<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;

// use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::query()->whereUserId(auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(5);
        $statuses = Order::STATUSES;

        return view('user.order.index', compact('orders', 'statuses'));
    }

    /**
     * @param Order $order
     * @return View
     */
    public function show(Order $order): View
    {
        if (auth()->user()->id !== $order->user_id) {
            // можно просматривать только свои заказы
            abort(404);
        }
        $statuses = Order::STATUSES;

        return view('user.order.show', compact('order', 'statuses'));
    }
}
