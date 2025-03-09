<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
</head>
<body>
    <h2>{{$user ? "Заказы ".$user->id."го "." пользователя "."(".$user->name." ".$user->last_name.")":'Неверный id'}}</h2>
    @if($user)
    <table border="1">
        <tr>
            <td>id</td>
            <td>Категория товара</td>
            <td>Наименование товара</td>
            <td>Цена инструмента</td>
            <td>Цена запланированная (общая)</td>
            <td>Цена фактическая (общая)</td>
        </tr>
        @foreach($user->equipments as $equipment)
            <tr>
                <td>{{$equipment->id}}</td>
                <td>{{$equipment->category->name}}</td>
                <td>{{$equipment->name}}</td>
                <td>{{$equipment->price}}</td>
                <td>{{$equipment->pivot->planned_cost}}</td>
                <td>{{$equipment->pivot->actual_amount}}</td>
            </tr>
        @endforeach

    </table>
    <h3>Суммарная запланированная стоимость аренды: {{ $totalPlannedCost }}</h3>
    <h3>Суммарная фактическая стоимость аренды: {{ $totalActualAmount }}</h3>
    @endif
</body>
</html>


