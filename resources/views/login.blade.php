{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--    <style>  .is-invalid { color: #ff2d20;}    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--@if($user)--}}
{{--    <h2>Здравствуйте, {{$user->name}}</h2>--}}
{{--    <a href="{{url('logout')}}">Выйти из системы</a>--}}
{{--@else--}}
{{--    <h2>Вход в систему</h2>--}}
{{--    <form method="post" action={{url('auth')}}>--}}
{{--    @csrf--}}
{{--    <label>E-mail</label>--}}
{{--    <input type="text" name="email" value="{{ old('email') }}"/>--}}
{{--    @error('email')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}
{{--    <label>Пароль</label>--}}
{{--    <input type="password" name="password" value="{{ old('password') }}"/>--}}
{{--    @error('password')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}
{{--    <input type="submit">--}}
{{--    </form>--}}
{{--    @error('error')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--@endif--}}
{{--</body>--}}
{{--</html>--}}





{{--@extends('layout')--}}
{{--@section('content')--}}

{{--    @if(Auth::user())--}}
{{--        <div class="container">--}}
{{--            <div class="row justify-content-center">--}}
{{--                <div class="col-md-8">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-header">{{ __('') }}</div>--}}

{{--                        <div class="card-body">--}}
{{--                            @if (session('status'))--}}
{{--                                <div class="alert alert-success" role="alert">--}}
{{--                                    {{ session('status') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <h1>{{__('Здравствуйте,')}} {{Auth::user()->name}}</h1>--}}
{{--                            {{ __('Вы в системе!') }}--}}

{{--                        </div>--}}

{{--                    </div>--}}
{{--                    <a href="{{ url('logout') }}" class="btn btn-danger btn-lg">--}}
{{--                        <i class="bi bi-box-arrow-right"></i> Выйти из системы--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--@endsection--}}




@extends('layout')
@section('content')

    <!-- Фоновое изображение -->
    <div class="background-image"></div>

    @if(Auth::user())
        <!-- Отображение для авторизованного пользователя -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h1>{{__('Здравствуйте,')}} {{Auth::user()->name}}</h1>
                            {{ __('Вы в системе!') }}
                        </div>
                    </div>
                    <a href="{{ url('logout') }}" class="btn btn-danger btn-lg mt-3">
                        <i class="bi bi-box-arrow-right"></i> Выйти из системы
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- Отображение для неавторизованного пользователя -->
        <div class="welcome-text">
            Добро пожаловать в мир инструментов!
        </div>
    @endif

    <!-- Всплывающие сообщения -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <style>
        /* Стили для фонового изображения */
        .background-image {
            background-image: url('https://img.freepik.com/free-vector/hand-drawn-diy-pattern-background_23-2150849919.jpg?t=st=1742660946~exp=1742664546~hmac=3f008ecf014640f91dc483a544947125a97f659f69aa7b10985757b6049039dd&w=1380');
            background-size: cover;
            background-position: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* Картинка на самом нижнем слое */
        }

        /* Стили для текста */
        .welcome-text {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            background-color: rgba(0, 0, 0, 0.5); /* Полупрозрачный фон для текста */
            padding: 20px;
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1; /* Текст поверх картинки */
        }

        /* Стили для контейнера с приветствием */
        .container {
            position: relative;
            z-index: 1; /* Контент поверх картинки */
        }
    </style>
@endsection
