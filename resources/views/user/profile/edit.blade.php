@extends('layouts.site', ['title' => 'Ваши профили'])
@section('content')

<h1>Редактирование профиля</h1>
    <form method="post" action="{{ route('user.profile.update', [$profile->id]) }}">
        @method('PUT')
        {{-- @include('user.profile.part.form') --}}
        <x-user.profile.part.form :profile='$profile'></x-user.profile.part.form>
    </form>

@endsection
