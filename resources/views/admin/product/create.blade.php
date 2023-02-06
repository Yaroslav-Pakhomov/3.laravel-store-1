@extends('layouts.admin', ['title' => 'Создание нового товара'])
@section('content')

    <h1>Создание нового товара</h1>
    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
        <x-admin.product.part.form :categories="$categories"  :brands="$brands"></x-admin.product.part.form>
    </form>

@endsection
