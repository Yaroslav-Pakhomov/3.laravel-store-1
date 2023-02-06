@extends('layouts.admin', ['title' => 'Все пользователи'])
@section('content')

<h1 class="mb-4">Все пользователи</h1>

<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th class="w-25">Дата регистрации</th>
        <th class="w-25">Имя, фамилия</th>
        <th class="w-25">Адрес почты</th>
        <th class="w-25">Кол-во заказов</th>
        <th><i class="fa fa-edit"></i></th>
    </tr>

    @foreach($users as $user)
{{--        @dd($user->orders())--}}
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
            <td>{{ $user->name }}</td>
            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
            <td>{{ $user->orders ? $user->orders()->count() : 0 }}</td>
            <td>
                <a href="{{ route('admin.user.edit', [$user->id]) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
</table>
{{ $users->links() }}

@endsection
