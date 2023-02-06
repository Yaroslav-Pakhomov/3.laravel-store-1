@extends('layouts.admin', ['title' => 'Все заказы'])
@section('content')

<h1>Все заказы</h1>

<table class="table table-bordered">
    <tr>
        <th>№</th>
        <th class="w-18">Дата и время</th>
        <th class="w-5">Статус</th>
        <th class="w-18">Покупатель</th>
        <th class="w-18">Адрес почты</th>
        <th class="w-18">Номер телефона</th>
        <th class="w-18">Пользователь</th>
        <th><i class="fa fa-eye"></i></th>
        <th><i class="fa fa-edit"></i></th>
    </tr>
    @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
            <td>
                    @if ($order->status == 0)
                        <span class="text-danger">{{ $statuses[$order->status] }}</span>
                    @elseif (in_array($order->status, [1,2,3]))
                        <span class="text-success">{{ $statuses[$order->status] }}</span>
                    @else
                        {{ $statuses[$order->status] }}
                    @endif
                </td>
            <td>{{ $order->name }}</td>
            <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
            <td>{{ $order->phone }}</td>
            <td>
                @isset($order->user)
                    {{ $order->user->name }}
                @endisset
            </td>
            <td>
                <a href="{{ route('admin.order.show', ['order' => $order->id]) }}">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
            <td>
                <a href="{{ route('admin.order.edit', ['order' => $order->id]) }}">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
        </tr>
    @endforeach
</table>
{{ $orders->links() }}

@endsection
