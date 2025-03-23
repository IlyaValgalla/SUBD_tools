{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<?php //var_dump($category) ?><!---->--}}

{{--   <h2>{{$category ? "Список инструментов категории ".$category->name : 'Неверный ID категории'}}</h2>--}}
{{--    @if($category)--}}
{{--    <table border="1">--}}
{{--        <thead>--}}
{{--            <td>id</td>--}}
{{--            <td>Наименование</td>--}}
{{--            <td>Цена</td>--}}
{{--        </thead>--}}
{{--    @foreach($category->equipment as $equipment)--}}
{{--            <tr>--}}
{{--                <td>{{$equipment->id}}</td>--}}
{{--                <td>{{$equipment->name}}</td>--}}
{{--                <td>{{$equipment->price}}</td>--}}
{{--            </tr>--}}
{{--    @endforeach--}}
{{--    </table>--}}
{{--    @endif--}}
{{--</body>--}}
{{--</html>--}}


@extends('layout')
@section('content')
    <div class="container">
        <h2>{{ $category ? "Список инструментов категории " . $category->name : 'Неверный ID категории' }}</h2>

        @if($category)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Наименование</th>
                        <th>Цена (за 1 шт.)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category->equipment as $equipment)
                        <tr>
                            <td>{{ $equipment->id }}</td>
                            <td>{{ $equipment->name }}</td>
                            <td>{{ $equipment->price }} ₽</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <a href="{{ url('/equipment')}}" class="btn btn-secondary mb-3">Назад</a>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                Категория с указанным ID не найдена.
            </div>
        @endif
    </div>
@endsection
