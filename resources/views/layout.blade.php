<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>605-11</title>
</head>

<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Instruments</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" aria-current="page" data-bs-toggle="dropdown"
                       href="{{ url('category') }}">Категория товаров</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('category') }}">Список категорий</a></li>
                        @can('create-category')
                            <li><a class="dropdown-item" href="{{ url('category/create') }}">Создать категорию</a></li>
                        @endcan
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" aria-current="page" data-bs-toggle="dropdown"
                       href="{{ url('equipment') }}">Товары</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ url('equipment') }}">Все товары</a></li>
                        <li><a class="dropdown-item" href="{{ url('equipment/create') }}">Добавить товар</a></li>
{{--                        <li><hr class="dropdown-divider"></li>--}}
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ url('rental') }}">Заказы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold text-white" href="{{ url('user') }}">Покупатели</a>
                </li>
            </ul>

            @if(!Auth::user())
                <form class="d-flex" method="post" action="{{ url('auth') }}">
                    @csrf
                    <input class="form-control me-2" type="text" placeholder="Логин" name="email" aria-label="Логин"
                           value="{{ old('email') }}"/>
                    <input class="form-control me-2" type="password" placeholder="Пароль" name="password" aria-label="Пароль"
                           value="{{ old('password') }}"/>
                    <button class="btn btn-outline-success" type="submit">Войти</button>
                </form>
            @else
                <ul class="navbar-nav">
                    <a class="nav-link active" href="#"><i class="fa fa-user" style="font-size:20px;color:white;"></i>
                        <span>  </span>{{ Auth::user()->name }}</a>
                    <a class="btn btn-outline-success my-2 my-sm-0" href="{{ url('logout') }}">Выйти</a>
                </ul>
            @endif
        </div>
    </div>
</nav>
<main class="flex-shrink-0" style="margin-top: 80px;">
    @yield('content')
</main>
    @include('error')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
