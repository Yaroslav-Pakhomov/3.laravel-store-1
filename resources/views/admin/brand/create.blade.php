@extends('layouts.admin', ['title' => 'Создание нового бренда'])
@section('content')

    <h1>Создание нового бренда</h1>
    <form method="POST" action="{{ route('admin.brand.store') }}" enctype="multipart/form-data">
{{--        <x-admin.brand.part.form :parentCategories="$parentCategories"></x-admin.brand.part.form>--}}
        <x-admin.brand.part.form></x-admin.brand.part.form>
    </form>

@endsection
