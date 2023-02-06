@extends('layouts.site', ['title' => $brand->name])
@section('content')

<h1>Бренд: {{ $brand->name }}</h1>

<p>{{ $brand->content }}</p>

<div class="bg-info p-2 mb-4">
    <!-- Фильтр для товаров бренда -->
    <form action="{{ route('catalog.brand', [$brand->slug]) }}" method="GET">
        <x-catalog.part.filter></x-catalog.part.filter>
        <a href="{{ route('catalog.brand', [$brand->slug]) }}"  class="btn btn-danger">Сбросить</a>
    </form>
</div>

<div class="row justify-content-center align-items-center">
    @foreach ($products as $product)
        <x-catalog.part.product :product="$product"></x-catalog.part.product>
    @endforeach
</div>

{{ $products->links() }}

@endsection
