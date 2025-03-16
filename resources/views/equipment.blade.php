<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
</head>
<body>
<h2>{{$equipment ? "Аренда инструмента: ".$equipment->name : 'Неверный ID '}}</h2>
@if($equipment)
    <table border="1">
        <thead>
        <tr>
            <th>ID аренды</th>
            <th>Начало аренды</th>
            <th>Конец аренды</th>
            <th>Цена плановая</th>
            <th>Цена фактическая</th>
            <th>ID пользователя</th>
            <th>Имя пользователя</th>
            <th>Email пользователя</th>
        </tr>
        </thead>
        <tbody>
        @foreach($equipment->rentals as $rental)
            <tr>
                <td>{{ $rental->id }}</td>
                <td>{{ $rental->start_date }}</td>
                <td>{{ $rental->end_date }}</td>
                <td>
                    {{ ((strtotime($rental->end_date) - strtotime($rental->start_date)) / 86400 + 1) * $equipment->price }}
                </td>
                <td>{{ $rental->actual_amount }}</td>
                <td>{{ $rental->user_id }}</td>
                <td>{{ $rental->user->name }}</td>
                <td>{{ $rental->user->email }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

</body>
</html>


