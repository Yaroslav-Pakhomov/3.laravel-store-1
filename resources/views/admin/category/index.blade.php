@extends('layouts.admin', ['title' => 'Все категории'])
@section('content')

    <h1>Все категории</h1>
    <a class="btn btn-outline-success mb-2" href="{{ route('admin.category.create') }}">Создать категорию</a>
    <table class="table table-bordered">
        <tr>
            <th class="w-15">Наименование</th>
            <th class="w-15">Картинка</th>
            <th class="w-65">Описание</th>
            <th><i class="fa fa-edit"></i></th>
            <th><i class="fa fa-trash-o"></i></th>
        </tr>
        <x-admin.category.part.tree :items="$categories"></x-admin.category.part.tree>
    </table>

@endsection
