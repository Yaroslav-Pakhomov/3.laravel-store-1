@extends('layouts.site', ['title' => $category->name])
@section('content')

<h1>Категория: {{ $category->name }}</h1>

<p>{{ $category->content }}</p>

<div class='row'>
    @foreach($category->children as $child)
        <x-catalog.part.category :category="$child"></x-catalog.part.category>
    @endforeach
</div>

<div class="bg-info p-2 mb-4">
    <!-- Фильтр для товаров категории -->
    <form action="{{ route('catalog.category', [$category->slug]) }}" method="GET">
        <x-catalog.part.filter></x-catalog.part.filter>
        <a href="{{ route('catalog.category', [$category->slug]) }}" class="btn btn-danger">Сбросить</a>
    </form>
</div>

<h5 class="bg-info text-white p-2 mb-4">Товары раздела</h5>

<div class="row">
    @foreach ($products as $product)
        <x-catalog.part.product :product="$product"></x-catalog.part.product>
    @endforeach
</div>
{{ $products->links() }}
@endsection
