@extends('layouts.site', ['title' => 'Оформление заказа'])
@section('content')

    {{--    @dd(auth()->user())--}}
    <h1>Оформление заказа</h1>
    @if ($profiles && $profiles->count())
        @php
            $current = $profile->id ?? 0;
        @endphp
        {{-- @include('basket.select', ['current' => $profile->id ?? 0]) --}}
        <x-basket.part.select :current='$current' :profile='$profile' :profiles='$profiles'></x-basket.part.select>
    @endif
    <form action="{{ route('basket.save-order') }}" method="POST">
        @csrf
        <div class="form-group mt-3">
            <label class="w-100">
                <input type="text" class="form-control" name="name" placeholder="Имя, Фамилия"
                       required maxlength="255" value="{{ old('name') ?? auth()->user()->name ?? '' }}">
            </label>
            @error('name')
            <div class="alert alert-danger mt-1"> {{ $message }} </div>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label class="w-100">
                <input type="email" class="form-control" name="email" placeholder="Адрес почты"
                       required maxlength="255" value="{{ old('email') ?? auth()->user()->email ?? '' }}">
            </label>
            @error('email')
            <div class="alert alert-danger mt-1"> {{ $message }} </div>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label class="w-100">
                <input type="text" class="form-control" name="phone" placeholder="Номер телефона"
                       required maxlength="255" value="{{ old('phone') ?? '' }}">
            </label>
            @error('phone')
            <div class="alert alert-danger mt-1"> {{ $message }} </div>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label class="w-100">
                <input type="text" class="form-control" name="address" placeholder="Адрес доставки"
                       required maxlength="255" value="{{ old('address') ?? '' }}">
            </label>
            @error('address')
            <div class="alert alert-danger mt-1"> {{ $message }} </div>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label class="w-100">
                <textarea class="form-control" name="comment" placeholder="Комментарий" maxlength="255"
                          rows="2">{{ old('comment') ?? '' }}</textarea>
            </label>
        </div>
        <div class="form-group mt-1">
            <button type="submit" class="btn btn-success">Оформить</button>
        </div>
    </form>

@endsection
