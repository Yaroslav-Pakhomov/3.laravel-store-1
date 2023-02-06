<?php

namespace App\Models;

// use App\Helpers\Exception\NullPointerException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cookie;
use RuntimeException;

/**
 * @method static findOrFail(array|string $basket_id)
 * @method static create()
 * @property mixed $products
 */
class Basket extends Model
{
    use HasFactory;

    protected $table = 'baskets';

    protected $guarded = [];

    /**
     * Возвращает объект корзины; если не найден — создает новый
     */
    public static function getBasket(): Basket
    {
        // Получаем 'basket_id' из cookie
        // request() - хэлпер запроса
        try {
            $request = request();
            if ($request && $request->cookie('basket_id') !== NULL) {
                $basket_id = $request->cookie('basket_id');
            } else {
                throw new RuntimeException('The $basket_id does not exist');
            }
        } catch (RuntimeException $e) {
            echo $e->getMessage();
            die();
        }
        if (!empty($basket_id)) {
            try {
                // корзина уже существует, получаем объект корзины
                $basket = self::findOrFail($basket_id);
            } catch (ModelNotFoundException) {
                $basket = self::create();
            }
        } else {
            // если корзина еще не существует — создаем объект Модели
            $basket = self::create();
        }
        // получаем идентификатор, чтобы записать в cookie - имя, значение и количество минут
        Cookie::queue('basket_id', $basket->id, 525600);

        return $basket;
    }

    /**
     * Возвращает количество позиций в корзине
     */
    public static function getCount(): int
    {
        $request = request();
        $basket_id = $request->cookie('basket_id');
        if (empty($basket_id)) {
            return 0;
        }

        return self::getBasket()->products()->count();
    }

    /**
     * Стоимость корзины
     */
    public function getAmount()
    {
        $amount = 0.0;
        foreach ($this->products as $product) {
            $amount = $amount + $product->price * $product->pivot->quantity;
        }

        return $amount;
    }

    /**
     * Связь «многие ко многим» таблицы `baskets` с таблицей `products`
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /**
     * Увеличивает кол-во товара $product_id в корзине на величину $count
     */
    public function increase(int $product_id, int $count = 1): void
    {
        $this->change($product_id, $count);
    }

    /**
     * Уменьшает кол-во товара $product_id в корзине на величину $count
     */
    public function decrease(int $product_id, int $count = 1): void
    {
        $this->change($product_id, -1 * $count);
    }

    /**
     * Удаляет товар с идентификатором $id из корзины покупателя
     */
    public function remove(int $product_id): void
    {
        // detach() - для удаления, обе модели останутся в базе данных
        $this->products()->detach($product_id);

        // обновляем поле `updated_at` таблицы `baskets`
        $this->touch();
    }

    /**
     * Изменяет кол-во товара $product_id на величину $count;
     */
    private function change(int $product_id, int $count = 0): void
    {
        if ($count === 0) {
            return;
        }

        // если товар есть в корзине — изменяем кол-во
        // Существует ли ключ в коллекции
        if ($this->products->contains($product_id)) {
            // получаем объект строки таблицы `basket_product`
            // с помощью атрибута pivot можно получить столбцы промежуточной таблицы для отношения «многие-ко-многим»
            $pivotRow = $this->products()->where('product_id', $product_id)->first()->pivot;

            // добавляем к кол-ву, которое пришло из input кол-во, хранящееся в промежуточной таблице 'basket_product'
            $quantity = $pivotRow->quantity + $count;
            if ($quantity > 0) {
                // обновляем кол-во товара $product_id в корзине
                // обновляем значение столбца 'quantity' в таблице 'basket_product'
                $pivotRow->update([ 'quantity' => $quantity ]);

                // Примечание !!!
                // Обновить значение pivot-поля quantity в промежуточной таблице basket_product можно с помощью метода
                // $this->products()->updateExistingPivot(
                //     $product_id,
                //     ['quantity', $quantity]
                // );
            } else {
                // кол-во равно нулю — удаляем товар из корзины
                $pivotRow->delete();
            }
        } elseif ($count > 0) {
            // если такого товара нет в корзине — добавляем его
            // attach() - метод для работы с отношениями «многие-ко-многим», вставляет необходимые данные в промежуточную таблицу 'basket_product'
            $this->products()->attach($product_id, [ 'quantity' => $count ]);
        }

        // метод модели, обновляем поле `updated_at` таблицы `baskets`, updateTimestamps() для обновления времени создания и обновления.
        $this->touch();
    }
}
