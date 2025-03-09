<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
</head>
<body>
<h2>>Список инструментов</h2>
    <table border="1">
        <thead>
        <td>id</td>
        <td>Наименование</td>
        <td>Категория</td>
        <td>Количество на складе</td>
        <td>Цена</td>

        </thead>
        @foreach($equipments as $equipment)
            <tr>
                <td>{{$equipment->id}}</td>
                <td>{{$equipment->name}}</td>
                <td>{{$equipment->category->name}}</td>
                <td>{{$equipment->quantity_in_stock}}</td>
                <td>{{$equipment->price}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
