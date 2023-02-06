<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     * временно отключим шифрование cookie, чтобы иметь возможность видеть значение, которые мы сохраняем в basket_id таблица 'basket_product', закомитеть после разработки.
     *
     * @var array<int, string>
     */

    protected $except = [
        'basket_id'
    ];
}
