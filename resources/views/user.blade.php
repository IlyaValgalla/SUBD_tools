{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--    <h2>{{$user ? "Заказы ".$user->id."го "." пользователя "."(".$user->name." ".$user->last_name.")":'Неверный id'}}</h2>--}}
{{--    @if($user)--}}
{{--    <table border="1">--}}
{{--        <tr>--}}
{{--            <td>id</td>--}}
{{--            <td>Категория товара</td>--}}
{{--            <td>Наименование товара</td>--}}
{{--            <td>Цена инструмента</td>--}}
{{--            <td>Цена запланированная (общая)</td>--}}
{{--            <td>Цена фактическая (общая)</td>--}}
{{--        </tr>--}}
{{--        @foreach($user->equipments as $equipment)--}}
{{--            <tr>--}}
{{--                <td>{{$equipment->id}}</td>--}}
{{--                <td>{{$equipment->category->name}}</td>--}}
{{--                <td>{{$equipment->name}}</td>--}}
{{--                <td>{{$equipment->price}}</td>--}}
{{--                <td>{{$equipment->pivot->planned_cost}}</td>--}}
{{--                <td>{{ $equipment->rentals->first()->planned_cost }}</td>--}}
{{--                <td>{{$equipment->pivot->actual_amount}}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        --}}

{{--    </table>--}}

{{--    <h3>Суммарная запланированная стоимость аренды: {{ $totalPlannedCost }}</h3>--}}
{{--    <h3>Суммарная фактическая стоимость аренды: {{ $totalActualAmount }}</h3>--}}
{{--    @endif--}}
{{--</body>--}}
{{--</html>--}}

    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Информация об аренде</title>
</head>
<body>
<h2>{{ $user ? "Заказы пользователя: ".$user->name." ".$user->last_name : 'Неверный ID' }}</h2>

@if($user)
    <table border="1">
        <tr>
            <th>ID аренды</th>
            <th>Категория инструмента</th>
            <th>Наименование инструмента</th>
            <th>Цена аренды за день</th>
            <th>Дата начала аренды</th>
            <th>Дата окончания аренды</th>
            <th>Запланированная стоимость</th>
            <th>Фактическая стоимость</th>
        </tr>

        @foreach($rentals as $rental)
            <tr>
                <td>{{ $rental->id }}</td>
                <td>{{ $rental->equipment->category->name }}</td>
                <td>{{ $rental->equipment->name }}</td>
                <td>{{ $rental->equipment->price }}</td>
                <td>{{ $rental->start_date }}</td>
                <td>{{ $rental->end_date }}</td>
                <td>
                    {{ (strtotime($rental->end_date) - strtotime($rental->start_date)) / 86400 * $rental->equipment->price }}
                </td>
                <td>{{ $rental->actual_amount }}</td>
            </tr>
        @endforeach
    </table>

    <h3>Суммарная запланированная стоимость аренды: {{ $totalPlannedCost }}</h3>
    <h3>Суммарная фактическая стоимость аренды: {{ $totalActualAmount }}</h3>
@endif
</body>
</html>

