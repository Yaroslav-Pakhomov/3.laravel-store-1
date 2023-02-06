@extends('layouts.admin', ['title' => 'Создание новой категории'])
@section('content')

{{--    @dd(count($parentCategories))--}}
    <h1>Создание новой категории</h1>
    <form method="POST" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
        <x-admin.category.part.form :parentCategories="$parentCategories"></x-admin.category.part.form>
    </form>

@endsection
