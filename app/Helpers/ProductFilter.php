<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductFilter
{

    private Builder $builder;
    private Request $request;

    public function __construct(Builder $builder, Request $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    public function apply(): Builder
    {
        foreach ($this->request->query() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Дешевые или дорогие товары
     * Фильтр по цене делит общее кол-во товаров пополам.
     * То есть 50% товаров попадают в дешевые,
     * а еще 50% — попадают в дорогие.
     */
    private function price($value): void
    {
        if (in_array($value, [ 'min', 'max' ])) {
            $products = $this->builder->get()->sortBy('price')->values();
            $count = $products->count();

            if ($count > 1) {
                $half = intdiv($count, 2);
                // если остаток 1
                if ($count % 2) {
                    // нечетное кол-во товаров, надо найти цену товара, который ровно посередине
                    $avg = $products[ $half ]['price'];
                } else {
                    // четное количество, надо найти такую цену, которая поделит товары пополам
                    $avg = 0.5 * ($products[ $half - 1 ]['price'] + $products[ $half ]['price']);
                }

                if ($this->request->price === 'min') {
                    $this->builder->where('price', '<=', $avg);
                } else {
                    $this->builder->where('price', '>=', $avg);
                }
            }
        }
    }

    /**
     * Отбираем только новинки
     */
    private function new($value): void
    {
        if ('yes' === $value) {
            $this->builder->where('new', TRUE);
        }
    }

    /**
     * Отбираем только лидеров продаж
     */
    private function hit($value): void
    {
        if ('yes' === $value) {
            $this->builder->where('hit', TRUE);
        }
    }

    /**
     * Отбираем только со скидкой
     */
    private function sale($value): void
    {
        if ('yes' === $value) {
            $this->builder->where('sale', TRUE);
        }
    }

}
