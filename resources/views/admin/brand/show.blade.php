@extends('layouts.admin', ['title' => 'Просмотр бренда'])
@section('content')
    <h1>Просмотр бренда</h1>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Название:</strong> {{ $brand->name }}</p>
            <p><strong>ЧПУ (англ):</strong> {{ $brand->slug }}</p>
            <p><strong>Краткое описание</strong></p>
            @isset($brand->content)
                <p>{{ $brand->content }}</p>
            @else
                <p>Описание отсутствует</p>
            @endisset
        </div>
        <div class="col-md-6">
            <img src="{{ $brand->full_image ?? 'https://via.placeholder.com/600x250' }}" alt="{{ $brand->slug }}" class="img-fluid">
        </div>
    </div>
{{--    @if ($brand->children->count())--}}
{{--        <p><strong>Дочерние бренды</strong></p>--}}
{{--        <table class="table table-bordered">--}}
{{--            <tr>--}}
{{--                <th>№</th>--}}
{{--                <th class="w-45">Наименование</th>--}}
{{--                <th class="w-45">ЧПУ (англ)</th>--}}
{{--                <th><i class="fa fa-edit"></i></th>--}}
{{--                <th><i class="fa fa-trash-o"></i></th>--}}
{{--            </tr>--}}
{{--            @foreach ($brand->children as $child)--}}
{{--                <tr>--}}
{{--                    <td>{{ $loop->iteration }}</td>--}}
{{--                    <td>--}}
{{--                        <a href="{{ route('admin.brand.show', [$child->id]) }}">--}}
{{--                            {{ $child->name }}--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                    <td>{{ $child->slug }}</td>--}}
{{--                    <td>--}}
{{--                        <a href="{{ route('admin.brand.edit', [$child->id]) }}">--}}
{{--                            <i class="fa fa-edit"></i>--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                    <td>--}}
{{--                        <form action="{{ route('admin.brand.delete', [$child->slug]) }}" method="post">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="m-0 p-0 border-0 bg-transparent">--}}
{{--                                <i class="fa fa-trash-o text-danger"></i>--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--        </table>--}}
{{--    @else--}}
{{--        <p>Нет дочерних брендов</p>--}}
{{--    @endif--}}
    <a href="{{ route('admin.brand.edit', [$brand->id]) }}"
       class="btn btn-success mt-3">
        Редактировать бренд
    </a>
    <form method="post"
          action="{{ route('admin.brand.delete', [$brand->slug]) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">
            Удалить бренд
        </button>
    </form>
@endsection
