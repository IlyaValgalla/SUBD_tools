{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--    <style>  .is-invalid { color: #ff2d20;}   </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h2>Добавление категории товара</h2>--}}
{{--<form method="post" action="{{ url('category') }}">--}}
{{--    @csrf--}}
{{--    <label>Наименование</label>--}}
{{--    <input type="text" name="name" value="{{old('name')}}">--}}
{{--    @error('name')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}
{{--    <input type="submit">--}}
{{--</form>--}}
{{--</body>--}}
{{--</html>--}}


@extends('layout')
@section('content')
    <div class="container">
        <h2>Добавление категории товара</h2>
        <div class="row justify-content-center">
            <div class="col-4">
                <form method="post" action="{{ url('category') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Наименование</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name') }}">
                        <div id="nameHelp" class="form-text">Введите наименование категории</div>
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
