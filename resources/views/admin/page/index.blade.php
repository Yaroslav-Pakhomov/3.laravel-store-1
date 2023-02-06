@extends('layouts.admin', ['title' => 'Все страницы сайта'])
@section('content')

<h1 class="mb-3">Все страницы сайта</h1>
<a href="{{ route('admin.page.create') }}" class="btn btn-success mb-4">
    Создать страницу
</a>

@if (count($pages))
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th class="w-45">Наименование</th>
            <th class="w-45">ЧПУ (англ.)</th>
            <th><i class="fa fa-edit"></i></th>
            <th><i class="fa fa-trash-o"></i></th>
        </tr>
        <x-admin.page.part.tree :level=-1 :parent=0 :pages="$pages"></x-admin.page.part.tree>
    </table>
@endif

@endsection
