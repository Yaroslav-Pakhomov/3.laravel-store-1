<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

// use Illuminate\Http\Request;

class BasketController extends Controller
{

    private object $basket;

    public function __construct()
    {
        $this->basket = Basket::getBasket();
    }

    /*
     * Показывает корзину покупателя
     */
    public function index(): View
    {
        $products = $this->basket->products;

        return view('basket.index', compact('products'));
    }

    /*
     * Форма оформления заказа
     *
     * @param Request $request
     * @return View
     */
    public function checkout(Request $request): View
    {
        $profile = null;
        $profiles = null;
        // если пользователь аутентифицирован
        if(auth()->check()) {
            $user = auth()->user();
            // и у него есть профили для оформления
            $profiles = $user->profiles;
            // и был запрошен профиль для оформления
            $prof_id = (int) $request->input('profile_id');
            if ($prof_id) {
                $profile = $user->profiles()->whereIdAndUserId($prof_id, $user->id)->first();
            }
        }

        return view('basket.checkout', compact('profile', 'profiles'));
    }


    /*
     * Добавляет товар $product в корзину
     */
    public function add(Request $request, Product $product): View|RedirectResponse
    {
        $quantity = $request->input('quantity') ? (int) $request->input('quantity') : 1;
        $this->basket->increase($product->id, $quantity);
        if (!$request->ajax()) {
            // выполняем редирект обратно на страницу, где была нажата кнопка «В корзину»
            // back() - перенаправит пользователя в его предыдущее местоположение
            return back();
        }

        // в случае ajax-запроса возвращаем html-код корзины в правом
        // верхнем углу, чтобы заменить исходный html-код, потому что
        // теперь количество позиций будет другим
        $positions = $this->basket->products->count();

        return view('basket.part.basket', compact('positions'));
    }

    /*
     * Уменьшение кол-во товара в корзине на единицу
     */
    public function minus(Product $product): RedirectResponse
    {
        $this->basket->decrease($product->id);

        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /*
     * Увеличение кол-во товара в корзине на единицу
     */
    public function plus(Product $product): RedirectResponse
    {
        $this->basket->increase($product->id);

        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /*
     * Удаляет товар с идентификатором $product->id из корзины
     */
    public function remove(Product $product): RedirectResponse
    {
        $this->basket->remove($product->id);

        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Сохранение заказа в БД
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveOrder(Request $request): RedirectResponse
    {
        // проверяем данные формы оформления
        try {
            $this->validate($request, [
                'name'    => 'required|max:255',
                'email'   => 'required|email|max:255',
                'phone'   => 'required|max:255',
                'address' => 'required|min:5|max:255',
            ]);
        } catch (ValidationException) {
        }
        // валидация пройдена, сохраняем заказ
        $basket = Basket::getBasket();
        $user_id = auth()->check() ? auth()->user()->id : NULL;
        $order = Order::query()->create(
            $request->all() + [ 'amount' => $basket->getAmount(), 'user_id' => $user_id ]
        );
        foreach ($basket->products as $product) {
            $order->items()->create(
                [
                    'product_id' => $product->id,
                    'name'       => $product->name,
                    'price'      => $product->price,
                    'quantity'   => $product->pivot->quantity,
                    'cost'       => $product->price * $product->pivot->quantity,
                ]);
        }
        // уничтожаем корзину
        $basket->delete();

        // return redirect()->route('basket.success')->with('success', 'Ваш заказ успешно размещен');
        return redirect()->route('basket.success')->with('order_id', $order->id);
    }

    /*
     * Сообщение об успешном оформлении заказа
     *
     * @return View|RedirectResponse
    */
    public function success(Request $request): View|RedirectResponse
    {
        if ($request->session()->exists('order_id')) {
            // сюда покупатель попадает сразу после успешного оформления заказа
            $order_id = $request->session()->pull('order_id');
            $order = Order::query()->findOrFail($order_id);

            return view('basket.success', compact('order'));
        }

        // если покупатель попал сюда случайно, не после оформления заказа,
        // ему здесь делать нечего — отправляем на страницу корзины
        return redirect()->route('basket.index');
    }

    /**
     * Полностью очищает содержимое корзины покупателя
     */
    public function clear(): RedirectResponse
    {
        $this->basket->delete();

        // выполняем редирект обратно на страницу корзины
        return redirect()->route('basket.index');
    }

     /**
     * Возвращает профиль пользователя в формате JSON
     *
     * @param  Request  $request
     * @return Response
     */
    public function profile(Request $request) {
        if ( !$request->ajax()) {
            abort(404);
        }
        if ( !auth()->check()) {
            return response()->json(['error' => 'Нужна авторизация!'], 404);
        }
        $user = auth()->user();
        $profile_id = (int) $request->input('profile_id');
        if ($profile_id) {
            $profile = $user->profiles()->whereIdAndUserId($profile_id, $user->id)->first();
            if ($profile) {
                return response()->json(['profile' => $profile]);
            }
        }

        return response()->json(['error' => 'Профиль не найден!'], 404);
    }

}
