@extends('layouts.site', ['title' => 'Ваша корзина'])
@section('content')

    <h1>Ваша корзина</h1>
    @if (count($products))
    @php
        $basketCost = 0;
    @endphp
    <form action="{{ route('basket.clear') }}" method="POST" class="text-end">
        @csrf
        <button type="submit" class="btn btn-outline-danger mb-4 mt-0">
            Очистить корзину
        </button>
    </form>
    <a href="{{ route('basket.checkout') }}" class="btn btn-outline-success float-end mb-4 mt-0">Оформить заказ</a>
    <table class='table table-bordered'>
        <tr>
            <th>№</th>
            <th>Наименование</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th colspan='2'>Стоимость</th>
        </tr>
        @foreach($products as $product)
            @php
                $itemPrice = $product->price;
                $itemQuantity = $product->pivot->quantity;
                $itemCost = $itemPrice * $itemQuantity;
                $basketCost += $itemCost;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('catalog.product', [$product->slug]) }}">{{ $product->name }}</a>
                </td>
                <td>{{ number_format($itemPrice, 2, '.', '') }}</td>
                <td>
                    <!-- Кнопка '-' -->
                    <form action="{{ route('basket.minus', [$product->slug]) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                            <i class="fa fa-minus-square"></i>
                        </button>
                    </form>

                    <span class="mx-1">{{ $itemQuantity }}</span>

                    <!-- Кнопка '+' -->
                    <form action="{{ route('basket.plus', [$product->slug]) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                            <i class="fa fa-plus-square"></i>
                        </button>
                    </form>

                </td>
                <td>{{ number_format($itemCost, 2, '.', '') }}</td>
                <td>
                    <form action="{{ route('basket.remove', [$product->slug]) }}" method="POST">
                        @csrf
                        <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        <tr>
            <th colspan='4' class='text-end'>Итого:</th>
            <th colspan='2'>{{ number_format($basketCost, 2, '.', '') }}</th>
        </tr>
    </table>

@else

    <p>Ваша корзина пуста.</p>
    <p>Здесь будут Ваши товары.</p>

@endif

@endsection
