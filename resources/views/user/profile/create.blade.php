@extends('layouts.site', ['title' => 'Ваши профили'])
@section('content')

<h1>Создание профиля</h1>
    <form method="post" action="{{ route('user.profile.store') }}">
        {{-- @include('user.profile.part.form') --}}
        <x-user.profile.part.form></x-user.profile.part.form>
    </form>

@endsection
