<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property mixed $id
 */
class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = [];

    public const STATUSES = [
        0 => 'Новый',
        1 => 'Обработан',
        2 => 'Оплачен',
        3 => 'Доставлен',
        4 => 'Завершен',
    ];

    /**
     * Связь «один ко многим» таблицы `orders` с таблицей `order_items`
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Преобразует дату и время создания заказа из UTC в Asia/Yekaterinburg
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getCreatedAtAttribute($value): bool|\Carbon\Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Asia/Yekaterinburg');
    }

    /**
     * Преобразует дату и время обновления заказа из UTC в Asia/Yekaterinburg
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getUpdatedAtAttribute($value): bool|\Carbon\Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Asia/Yekaterinburg');
    }

}
