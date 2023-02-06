@extends('layouts.admin', ['title' => 'Все товары'])
@section('content')

<h1>Все товары</h1>
<ul>
@foreach ($roots as $root)
    <li>
        <a href="{{ route('admin.product.category', [ $root->id]) }}">
            {{ $root->name }}
        </a>
    </li>
@endforeach
</ul>
<a href="{{ route('admin.product.create') }}" class="btn btn-success mb-4">
    Создать товар
</a>
<table class="table table-bordered">
    <tr>
        <th width="30%">Наименование</th>
        <th width="65%">Описание</th>
        <th><i class="fa fa-edit"></i></th>
        <th><i class="fa fa-trash-o"></i></th>
    </tr>
    @foreach ($products as $product)
    <tr>
        <td>
            <a href="{{ route('admin.product.show', [$product->id]) }}">
                {{ $product->name }}
            </a>
        </td>
        <td>{{ iconv_substr($product->content, 0, 150) }}</td>
        <td>
            <a href="{{ route('admin.product.edit', [$product->id]) }}">
                <i class="fa fa-edit"></i>
            </a>
        </td>
        <td>
            <form action="{{ route('admin.product.delete', [$product->id]) }}" method="post" onsubmit="return confirm('Удалить этот товар?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                    <i class="fa fa-trash-o text-danger"></i>
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
{{ $products->links() }}

@endsection
