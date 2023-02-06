@extends('layouts.site')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<h1>Личный кабинет</h1>
<p>Добро пожаловать, {{ auth()->user()->name }}</p>
<p>Это личный кабинет постоянного покупателя нашего интернет-магазина.</p>

<ul>
    <li><a href="{{ route('user.profile.index') }}">Ваши профили</a></li>
    <li><a href="{{ route('user.order.index') }}">Ваши заказы</a></li>
</ul>

<form action="{{ route('user.logout') }}" method="post">
    @csrf
    <button type="submit" class="btn btn-primary">Выйти</button>
</form>

@endsection
