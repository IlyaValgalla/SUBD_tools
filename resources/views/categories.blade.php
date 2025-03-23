{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--    <h2>Список категорий:</h2>--}}
{{--    <table border="1">--}}
{{--        <thead>--}}
{{--            <td>id</td>--}}
{{--            <td>Наименование</td>--}}
{{--            <td>Действия</td>--}}
{{--        </thead>--}}
{{--    @foreach($categories as $category)--}}
{{--            <tr>--}}
{{--                <td>{{$category->id}}</td>--}}
{{--                <td>{{$category->name}}</td>--}}
{{--                <td><a href="{{url('category/destroy/'.$category->id)}}">Удалить</a>--}}
{{--                    <a href="{{url('category/edit/'.$category->id)}}">Редактировать</a>--}}
{{--            </tr>--}}
{{--    @endforeach--}}
{{--    </table>--}}
{{--    <br>--}}
{{--    <a href='/category/create'>--}}
{{--        <button type="button">Создать категорию</button>--}}
{{--    </a>--}}
{{--    <br>--}}
{{--    <div>{{ $categories->links() }}</div>--}}
{{--</body>--}}
{{--</html>--}}


@extends('layout')
@section('content')
    <div class="container">
        <h2>Список категорий</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                <tr>
                    <th class="text-center">ID</th> <!-- Центрируем заголовок -->
                    <th class="text-center">Наименование</th> <!-- Центрируем заголовок -->
                    <th class="text-center" style="width: 150px;">Действия</th> <!-- Центрируем заголовок -->
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td class="text-center">{{ $category->id }}</td> <!-- Центрируем текст -->
                        <td class="text-center">{{ $category->name }}</td> <!-- Центрируем текст -->
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center"> <!-- Центрируем кнопки -->
                                <a href="{{ url('category/edit/' . $category->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                                <a href="{{ url('category/destroy/' . $category->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить эту категорию?')">Удалить</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ url('category/create') }}" class="btn btn-success">Создать категорию</a>
            <div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
