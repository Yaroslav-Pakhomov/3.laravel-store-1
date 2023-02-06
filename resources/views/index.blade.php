@extends('layouts.site')
@section('content')

<h1>Интернет-магазин</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quidem, explicabo praesentium assumenda fuga fugit ea quas doloribus fugiat odit tenetur delectus deleniti earum ratione minus, cupiditate veritatis asperiores suscipit.</p>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quidem, explicabo praesentium assumenda fuga fugit ea quas doloribus fugiat odit tenetur delectus deleniti earum ratione minus, cupiditate veritatis asperiores suscipit.</p>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quidem, explicabo praesentium assumenda fuga fugit ea quas doloribus fugiat odit tenetur delectus deleniti earum ratione minus, cupiditate veritatis asperiores suscipit.</p>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis quidem, explicabo praesentium assumenda fuga fugit ea quas doloribus fugiat odit tenetur delectus deleniti earum ratione minus, cupiditate veritatis asperiores suscipit.</p>

@if($new->count())
<h2>Новинки</h2>
<div class="row">
    @foreach($new as $item)
        {{-- @include('catalog.part.product', ['product' => $item]) --}}
        <x-catalog.part.product :product="$item" />
    @endforeach
</div>
@endif

@if($hit->count())
<h2>Лидеры продаж</h2>
<div class="row">
    @foreach($hit as $item)
        <x-catalog.part.product :product="$item" />
    @endforeach
</div>
@endif

@if($sale->count())
<h2>Распродажа</h2>
<div class="row">
    @foreach($sale as $item)
        <x-catalog.part.product :product="$item" />
    @endforeach
</div>
@endif

@endsection
