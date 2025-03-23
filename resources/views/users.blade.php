{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h2>Информация о пользователях</h2>--}}
{{--    <table border="1">--}}
{{--        <tr>--}}
{{--            <td>id</td>--}}
{{--            <td>Имя</td>--}}
{{--            <td>Фамилия</td>--}}
{{--            <td>Номер телефона</td>--}}
{{--            <td>email</td>--}}
{{--        </tr>--}}

{{--        @foreach($users as $User)--}}
{{--            <tr>--}}
{{--                <td>{{$User->id}}</td>--}}
{{--                <td>{{$User->name}}</td>--}}
{{--                <td>{{$User->last_name}}</td>--}}
{{--                <td>{{$User->phone_number}}</td>--}}
{{--                <td>{{$User->email}}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    </table>--}}
{{--</body>--}}
{{--</html>--}}


@extends('layout')
@section('content')
    <div class="container">
        <h2>Информация о пользователях</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Номер телефона</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>
                            <a href="{{route('user.show',['id'=>$user->id])}}">
                            {{ $user->email }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
