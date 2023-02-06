@extends('layouts.admin', ['title' => 'Просмотр страницы'])
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Панель управления</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.page.index') }}">Страницы сайта</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $page->name }}</li>
    </ol>
</nav>
<h1>Просмотр страницы</h1>
<div class="row">
    <div class="col-12">
        <p><strong>Название:</strong> {{ $page->name }}</p>
        <p><strong>ЧПУ (англ):</strong> {{ $page->slug }}</p>
        <p><strong>Контент (html)</strong></p>
        <div class="mb-4 bg-white p-1">
{{--            {!! $page->content  !!}--}}
            @php echo nl2br(htmlspecialchars($page->content)) @endphp
        </div>

        <a href="{{ route('admin.page.edit', [$page->id]) }}"
            class="btn btn-success">
            Редактировать страницу
        </a>
        <form method="post" class="d-inline"  onsubmit="return confirm('Удалить эту страницу?')"
                action="{{ route('admin.page.delete', [$page->slug]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Удалить страницу
            </button>
        </form>
    </div>
</div>

@endsection
