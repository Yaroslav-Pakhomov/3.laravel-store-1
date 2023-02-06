@extends('layouts.site', ['title' => 'Ваши заказы'])
@section('content')

<h1>Ваши заказы</h1>

@if($orders->count())
    <table class="table table-bordered">
        <tr>
            <th class='w-2'>№</th>
            <th class='w-19'>Дата и время</th>
            <th class='w-13'>Статус</th>
            <th class='w-19'>Покупатель</th>
            <th class='w-24'>Адрес покупателя</th>
            <th class='w-21'>Номер телефона</th>
            <th class='w-2'><i class="fa fa-eye"></i></th>
        </tr>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td>{{ $statuses[$order->status] }}</td>
                <td>{{ $order->name }}</td>
                <td>
                    <a href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                </td>
                <td>{{ $order->phone }}</td>
                <td>
                    <a href="{{ route('user.order.show', [$order->id]) }}">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $orders->links() }}
@else
    <p>Заказов пока нет.</p>
@endif

@endsection
