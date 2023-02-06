@extends('layouts.admin', ['title' => 'Редактирование товара'])
@section('content')

    <h1>Редактирование товара</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.product.update', [$product->id]) }}">
        @method('PUT')
        <x-admin.product.part.form :product="$product" :categories="$categories" :brands="$brands"></x-admin.product.part.form>
    </form>

@endsection
