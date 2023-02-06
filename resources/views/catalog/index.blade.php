@extends('layouts.site', ['title' => 'Каталог товаров'])
@section('content')

<h1>Каталог товаров</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quidem, explicabo praesentium assumenda fuga fugit ea quas doloribus fugiat odit tenetur delectus deleniti earum ratione minus, cupiditate veritatis asperiores suscipit.</p>

<h2 class="mb-4">Разделы каталога</h2>
<div class="row">
    @foreach ($categories as $category)
        <x-catalog.part.category :category="$category" />
    @endforeach
</div>

<h2 class="mb-4">Популярные бренды</h2>
<div class="row">
    @foreach ($brands as $brand)
        <x-catalog.part.brand :brand="$brand" />
    @endforeach
</div>

@endsection
