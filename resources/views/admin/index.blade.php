@extends('layouts.admin', ['title' => 'Админ-панель'])
@section('content')

    <h1>Панель управления</h1>
    <p>Добро пожаловать, {{ auth()->user()->name ?? 'Админ' }}!</p>
    <div class='card-body p-0 m-auto text-center'>
        <img src="{{ Vite::asset('resources/images/default.jpg') }}" alt="{{ auth()->user()->name ?? 'Админ' }}"
             class="img-fluid w-75">
    </div>
    <p>Это панель управления для администратора интернет-магазина.</p>

@endsection
