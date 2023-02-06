@extends('layouts.admin', ['title' => 'Редактирование заказа'])
@section('content')

<h1 class="mb-4">Редактирование заказа</h1>
<form method="post" action="{{ route('admin.order.update', ['order' => $order->id]) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        @php $status = old('status') ?? $order->status ?? 0; @endphp
        <select name="status" class="form-control" title="Статус заказа">
        @foreach ($statuses as $key => $value)
            <option value="{{ $key }}" @if ($key == $status) selected @endif>
                {{ $value }}
            </option>
        @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="name"></label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Имя, Фамилия"
                                         required maxlength="255" value="{{ old('name') ?? $order->name ?? '' }}">
    </div>
    <div class="form-group">
        <label for="email"></label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Адрес почты"
                                          required maxlength="255" value="{{ old('email') ?? $order->email ?? '' }}">
    </div>
    <div class="form-group">
        <label for="phone"></label>
        <input type="text" class="form-control" name="phone" id="phone" placeholder="Номер телефона"
                                          required maxlength="255" value="{{ old('phone') ?? $order->phone ?? '' }}">
    </div>
    <div class="form-group">
        <label for="address"></label>
        <input type="text" class="form-control" name="address" id="address" placeholder="Адрес доставки"
                                            required maxlength="255" value="{{ old('address') ?? $order->address ?? '' }}">
    </div>
    <div class="form-group">
        <label for="comment"></label>
        <textarea class="form-control" name="comment" id="comment" placeholder="Комментарий"
                                               maxlength="255" rows="2">{{ old('comment') ?? $order->comment ?? '' }}</textarea>
    </div>
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-success">Сохранить</button>
    </div>
</form>

@endsection
