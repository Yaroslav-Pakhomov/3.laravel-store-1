<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $guarded = [];

    /**
     * Связь «элемент принадлежит» таблицы `order_items` с таблицей `products`
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
