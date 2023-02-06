@extends('layouts.admin', ['title' => 'Создание новой страницы'])

@section('content')
    <h1>Создание новой страницы</h1>
    <form method="post" action="{{ route('admin.page.store') }}">
        {{-- @include('admin.page.part.form') --}}
        <x-admin.page.part.form :parents="$parents"></x-admin.page.part.form>
    </form>
@endsection
