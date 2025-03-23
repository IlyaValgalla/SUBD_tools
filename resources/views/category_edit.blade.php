{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--    <style> .is-invalid { color: #ff2d20;}</style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h2>Редактирование категории товара</h2>--}}
{{--<form method="post" action="{{ url('category/update/' .$category->id) }}">--}}
{{--    @csrf--}}
{{--    @method('PUT') <!-- Добавляем метод PUT для обновления -->--}}

{{--    <!-- Поле "Наименование" -->--}}
{{--    <label>Наименование</label>--}}
{{--    <input type="text" name="name" value="{{ old('name', $category->name) }}" />--}}
{{--    @error('name')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}

{{--    <!-- Кнопка отправки формы -->--}}
{{--    <input type="submit" value="Обновить">--}}
{{--</form>--}}
{{--</body>--}}
{{--</html>--}}


@extends('layout')
@section('content')
    <div class="container">
        <h2>Редактирование категории товара</h2>
        <div class="row justify-content-center">
            <div class="col-4">
                <form method="post" action="{{ url('category/update/' . $category->id) }}">
                    @csrf
                    @method('PUT') <!-- Добавляем метод PUT для обновления -->

                    <!-- Поле "Наименование" -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Наименование</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="@if(old('name')) {{old('name')}} @else {{$category->name}} @endif"/>
                        <div id="nameHelp" class="form-text">Введите наименование категории</div>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Кнопка отправки формы -->
                    <button type="submit" class="btn btn-primary">Обновить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
