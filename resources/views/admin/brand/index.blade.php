@extends('layouts.admin', ['title' => 'Все бренды'])
@section('content')

    <h1>Все бренды</h1>
    <a class="btn btn-outline-success mb-2" href="{{ route('admin.brand.create') }}">Создать бренды</a>
    <table class="table table-bordered">
        <tr>
            <th class="w-15">Наименование</th>
            <th class="w-15">Картинка</th>
            <th class="w-65">Описание</th>
            <th><i class="fa fa-edit"></i></th>
            <th><i class="fa fa-trash-o"></i></th>
        </tr>
{{--        @foreach($brands as $brand)--}}
{{--            <tr>--}}
{{--                <td>--}}
{{--                    <a href="{{ route('admin.brand.show', ['brand' => $brand->id]) }}">--}}
{{--                        {{ $brand->name }}--}}
{{--                    </a>--}}
{{--                </td>--}}
{{--                <td>{{ iconv_substr($brand->content, 0, 150) }}</td>--}}
{{--                <td>--}}
{{--                    <a href="{{ route('admin.brand.edit', ['brand' => $brand->id]) }}">--}}
{{--                        <i class="far fa-edit"></i>--}}
{{--                    </a>--}}
{{--                </td>--}}
{{--                <td>--}}
{{--                    <form action="{{ route('admin.brand.delete', ['brand' => $brand->id]) }}"--}}
{{--                          method="post">--}}
{{--                        @csrf--}}
{{--                        @method('DELETE')--}}
{{--                        <button type="submit" class="m-0 p-0 border-0 bg-transparent">--}}
{{--                            <i class="far fa-trash-alt text-danger"></i>--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
        <x-admin.brand.part.tree :items="$brands"></x-admin.brand.part.tree>
    </table>

@endsection
