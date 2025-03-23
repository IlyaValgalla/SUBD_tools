{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h2>>Список инструментов</h2>--}}
{{--    <table border="1">--}}
{{--        <thead>--}}
{{--        <td>id</td>--}}
{{--        <td>Наименование</td>--}}
{{--        <td>Категория</td>--}}
{{--        <td>Количество на складе</td>--}}
{{--        <td>Цена</td>--}}
{{--        <td>Действия</td>--}}

{{--        </thead>--}}
{{--        @foreach($equipments as $equipment)--}}
{{--            <tr>--}}
{{--                <td>{{$equipment->id}}</td>--}}
{{--                <td>{{$equipment->name}}</td>--}}
{{--                <td>{{$equipment->category->name}}</td>--}}
{{--                <td>{{$equipment->quantity_in_stock}}</td>--}}
{{--                <td>{{$equipment->price}}</td>--}}
{{--                <td><a href="{{url('equipment/destroy/'.$equipment->id)}}">Удалить</a>--}}
{{--                    <a href="{{url('equipment/edit/'.$equipment->id)}}">Редактировать</a>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    </table>--}}

{{--<br>--}}

{{--<a href='/equipment/create'>--}}
{{--    <button type="button">Создать оборудование</button>--}}
{{--</a>--}}
{{--<br>--}}

{{--<div>{{ $equipments->links() }}</div>--}}

{{--</body>--}}
{{--</html>--}}


@extends('layout')
@section('content')
    <div class="container">
        <h2>Список инструментов</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Категория</th>
                    <th>Количество на складе</th>
                    <th>Цена (за 1 ед.)</th>
                    <th style="width: 365px;">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($equipments as $equipment)
                    <tr>
                        <td>{{ $equipment->id }}</td>
                        <td>
                            @can('view-equipment-rentals')
                                <a href="{{ route('equipment.show', ['id' => $equipment->id]) }}">
                                    {{ $equipment->name }}
                                </a>
                            @else
                                {{ $equipment->name }}
                            @endcan
                        </td>
                        <td>
                            <a href="{{route('category.show',['id'=>$equipment->category->id])}}">
                            {{ $equipment->category->name }}
                            </a>
                        </td>
                        <td>{{ $equipment->quantity_in_stock }}</td>
                        <td>{{ $equipment->price }}</td>
                        <td>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-success btn-sm">Добавить в корзину</a>
                            <a href="{{ url('equipment/edit/' . $equipment->id) }}" class="btn btn-primary btn-sm">Редактировать</a>
                            <a href="{{ url('equipment/destroy/' . $equipment->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этот инструмент?')">Удалить</a>
                        </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ url('equipment/create') }}" class="btn btn-success">Создать оборудование</a>
            <a href="{{ url('category/create') }}" class="btn btn-success">Создать категорию оборудования</a>
            <div>
                {{ $equipments->links() }}
            </div>
        </div>


    </div>
@endsection
