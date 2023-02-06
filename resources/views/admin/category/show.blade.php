@extends('layouts.admin', ['title' => 'Просмотр категории'])
@section('content')
    <h1>Просмотр категории</h1>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Название:</strong> {{ $category->name }}</p>
            <p><strong>ЧПУ (англ):</strong> {{ $category->slug }}</p>
            <p><strong>Краткое описание</strong></p>
            @isset($category->content)
                <p>{{ $category->content }}</p>
            @else
                <p>Описание отсутствует</p>
            @endisset
        </div>
        <div class="col-md-6">
            <img src="{{ $category->full_image ?? 'https://via.placeholder.com/600x250' }}" alt="{{ $category->slug }}" class="img-fluid">
        </div>
    </div>
    @if ($category->children->count())
        <p><strong>Дочерние категории</strong></p>
        <table class="table table-bordered">
            <tr>
                <th>№</th>
                <th class="w-45">Наименование</th>
                <th class="w-45">ЧПУ (англ)</th>
                <th><i class="fa fa-edit"></i></th>
                <th><i class="fa fa-trash-o"></i></th>
            </tr>
            @foreach ($category->children as $child)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('admin.category.show', [$child->id]) }}">
                            {{ $child->name }}
                        </a>
                    </td>
                    <td>{{ $child->slug }}</td>
                    <td>
                        <a href="{{ route('admin.category.edit', [$child->id]) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.category.delete', [$child->slug]) }}" method="post">
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
    @else
        <p>Нет дочерних категорий</p>
    @endif
    <a href="{{ route('admin.category.edit', [$category->id]) }}"
       class="btn btn-success mt-3">
        Редактировать категорию
    </a>
    <form method="post"
          action="{{ route('admin.category.delete', [$category->slug]) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">
            Удалить категорию
        </button>
    </form>
@endsection
