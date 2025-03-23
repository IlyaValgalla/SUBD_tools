{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h2>>Список инструментов в аренде</h2>--}}
{{--<table border="1">--}}
{{--    <thead>--}}
{{--    <td>id Инструмента</td>--}}
{{--    <td>Id Категория</td>--}}
{{--    <td>Категория</td>--}}
{{--    <td>Наименование</td>--}}
{{--    <td>Арендатор</td>--}}
{{--    <td>id Арендатора</td>--}}
{{--    <th>Начало аренды</th>--}}
{{--    <th>Конец аренды</th>--}}

{{--    </thead>--}}
{{--    @foreach($rentals as $rental)--}}
{{--        <tr>--}}
{{--            <td>{{$rental->equipment->id}}</td>--}}
{{--            <td>{{$rental->equipment->category->id}}</td>--}}
{{--            <td>{{$rental->equipment->category->name}}</td>--}}
{{--            <td>{{$rental->equipment->name}}</td>--}}
{{--            <td>{{$rental->user->name}}</td>--}}
{{--            <td>{{$rental->user_id}}</td>--}}
{{--            <td>{{$rental->start_date}}</td>--}}
{{--            <td>{{$rental->end_date}}</td>--}}
{{--        </tr>--}}
{{--    @endforeach--}}
{{--</table>--}}
{{--</body>--}}
{{--</html>--}}


@extends('layout')
@section('content')
    <div class="container">
        <h2>Список инструментов в аренде</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>ID Инструмента</th>
                    <th>Категория</th>
                    <th>Наименование</th>
                    <th>Арендатор</th>
                    <th>ID Арендатора</th>
                    <th>Начало аренды</th>
                    <th>Конец аренды</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->equipment->id }}</td>
                        <td>{{ $rental->equipment->category->name }}</td>
                        <td>{{ $rental->equipment->name }}</td>
                        <td>{{ $rental->user->name }}</td>
                        <td>{{ $rental->user_id }}</td>
                        <td>{{ $rental->start_date }}</td>
                        <td>{{ $rental->end_date }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
