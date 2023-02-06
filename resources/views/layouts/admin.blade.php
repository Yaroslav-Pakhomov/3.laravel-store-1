<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Панель управления' }}</title>

    <link rel="shortcut icon" href="{{ asset('laravel_logo.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


    @vite(['resources/js/app.js'])
    @vite(['resources/js/site.js'])
    @vite(['resources/js/admin.js'])
    @vite(['resources/js/jquery-scripts.js'])

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <!-- Бренд и кнопка «Гамбургер» -->
        <a class="navbar-brand" href="{{ route('index') }}">Сайт</a>
        <a class="navbar-brand" href="{{ route('admin.index') }}">Панель управления</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-example"
                aria-controls="navbar-example" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Основная часть меню (может содержать ссылки, формы и прочее) -->
        <div class="collapse navbar-collapse" id="navbar-example">
            <!-- Этот блок расположен слева -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.order.index') }}">Заказы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.user.index') }}">Пользователи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.category.index') }}">Категории</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.brand.index') }}">Бренды</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.product.index') }}">Товары</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.page.index') }}">Страницы сайта</a>
                </li>
            </ul>

            <!-- Этот блок расположен справа -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a onclick="document.getElementById('logout-form').submit(); return false"
                       href="{{ route('user.logout') }}" class="nav-link btn btn-danger">Выйти</a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('user.logout') }}" method="post" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class='alert alert-success alert-dismissible mt-3' role='alert'>
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Закрыть">
                        <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                    {{ $message }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible mt-0" role="alert">
                    <button type="button" class="btn-close w-5" data-dismiss="alert" aria-label="Закрыть">
                        <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
</div>
</body>
<script>
    let btn_close_success = document.querySelector('.alert-success .btn-close');
    if (btn_close_success) {
        btn_close_success.addEventListener('click', function () {
            let div_success = document.querySelector('.alert.alert-success.alert-dismissible');
            div_success.style.display = "none";
        });
    }
    let btn_close_danger = document.querySelector('.alert-danger .btn-close');
    if (btn_close_danger) {
        btn_close_danger.addEventListener('click', function () {
            let div_danger = document.querySelector('.alert.alert-danger.alert-dismissible');
            div_danger.style.display = "none";
        });
    }
</script>

</html>
