@extends('layouts.admin', ['title' => 'Редактирование категории'])
@section('content')

    <h1>Редактирование категории</h1>
    <form method="POST" enctype="multipart/form-data"
          action="{{ route('admin.category.update', [$category->id]) }}">
        @method('PUT')
        <x-admin.category.part.form :parentCategories="$parentCategories" :category="$category"></x-admin.category.part.form>
    </form>

@endsection
