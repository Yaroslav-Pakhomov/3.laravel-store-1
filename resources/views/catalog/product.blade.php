@extends('layouts.site', ['title' => $product->name])
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>{{ $product->name }}</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 position-relative">
                        <div class="position-absolute">
                            @if($product->new)
                                <span class="badge badge-info text-white ml-1">Новинка</span>
                            @endif
                            @if($product->hit)
                                <span class="badge badge-danger ml-1">Лидер продаж</span>
                            @endif
                            @if($product->sale)
                                <span class="badge badge-success ml-1">Распродажа</span>
                            @endif
                        </div>
                        <img src="{{ Vite::asset('resources/images/default2.jpg') }}" alt="{{ $product->name }}" class="img-fluid">
                    </div>
                    <div class="col-md-4">
                        <h4>Товар</h4>

                        <p>Цена: {{ number_format($product->price, 2, '.', '') }}</p>

                        {{-- Форма для добавления товара в корзину --}}
                        <form action="{{ route('basket.add', [$product->slug]) }}" method="POST" class="form-inline add-to-basket">
                            @csrf
                            <div class="d-flex align-items-center">
                                <label for="input-quantity">Количество</label>
                                <input type="text" name="quantity" id='input-quantity' value="1" class="form-control mx-2 w-25">
                            </div>
                            <button type="submit" class='btn btn-success mt-3'>Добавить в корзину</button>
                        </form>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="mt-4 mb-0">{{ $product->content }}</p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        Категория:
                        <a href="{{ route('catalog.category', [$product->category->slug]) }}">
                            {{ $product->category->name }}
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        Бренд:
                        <a href="{{ route('catalog.brand', [$product->brand->slug]) }}">
                            {{ $product->brand->name }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
