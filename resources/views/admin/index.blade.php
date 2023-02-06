@extends('layouts.admin', ['title' => 'Админ-панель'])
@section('content')

<h1>Панель управления</h1>
<p>Добро пожаловать, {{ auth()->user()->name }}</p>
<p>Это панель управления для администратора интернет-магазина.</p>

@endsection
