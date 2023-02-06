<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

<!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>{{ $title ?? 'Интернет-магазин' }}</title>

    <link rel="shortcut icon" href="{{ asset('laravel_logo.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- один css-файл -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- два js-скрипта -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ru-RU.min.js"></script>
    @vite(['resources/js/app.js'])
    @vite(['resources/js/site.js'])
<!-- {{ Vite::asset('resources/images/default.jpg') }} -->

</head>

<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('index') }}">
                Laravel-магазин
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Основная часть меню (может содержать ссылки, формы и прочее) -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Этот блок расположен слева -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog.index') }}">Каталог</a>
                    </li>
                    <x-page></x-page>
                </ul>

                <!-- Right Side Of Navbar -->


                <!-- Этот блок расположен посередине -->
                <form class="form-inline my-2 my-lg-0 d-flex" action="{{ route('catalog.search') }}">
                    <input class="form-control mr-sm-2" type="search" name="query" placeholder="Поиск по каталогу"
                           aria-label="Search">
                    <button class="btn btn-outline-info my-2 my-sm-0 ms-1" type="submit">Поиск</button>
                </form>

                <!-- Этот блок расположен справа -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link @if ($positions) text-success @endif" href="{{ route('basket.index') }}">
                            Корзина
                            @if ($positions) ({{ $positions }}) @endif
                        </a>
                    </li>

{{--                    @dd(auth()->user())--}}
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">Войти</a>
                        </li>
                        @if (Route::has('user.register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.register') }}">Регистрация</a>
                            </li>
                        @endif
                    @endguest
                    @auth
                        @if (auth()->user()->admin === 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.index') }}">Админ-панель</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.index') }}">Личный кабинет</a>
                            </li>
                        @endif
                        <form action="{{ route('user.logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Выйти</button>
                        </form>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="row mt-4">
        <div class="col-md-3">
            <h4>Разделы каталога</h4>

            {{-- Категории --}}
            <x-category></x-category>

            {{-- Популярные бренды --}}
            <x-brand></x-brand>
        </div>
        <div class="col-md-9">
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
                    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Закрыть">
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
    </main>
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
