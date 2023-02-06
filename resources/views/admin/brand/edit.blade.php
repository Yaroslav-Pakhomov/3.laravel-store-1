@extends('layouts.admin', ['title' => 'Редактирование бренда'])
@section('content')

    <h1>Редактирование бренда</h1>
    <form method="POST" enctype="multipart/form-data"
          action="{{ route('admin.brand.update', [$brand->id]) }}">
        @method('PUT')
{{--        <x-admin.brand.part.form :parentCategories="$parentCategories" :brand="$brand"></x-admin.brand.part.form>--}}
        <x-admin.brand.part.form :brand="$brand"></x-admin.brand.part.form>
    </form>

@endsection
