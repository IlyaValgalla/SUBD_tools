<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
</head>
<body>
<?php //var_dump($category) ?><!---->

   <h2>{{$category ? "Список инструментов категории ".$category->name : 'Неверный ID категории'}}</h2>
    @if($category)
    <table border="1">
        <thead>
            <td>id</td>
            <td>Наименование</td>
            <td>Цена</td>
        </thead>
    @foreach($category->equipment as $equipment)
            <tr>
                <td>{{$equipment->id}}</td>
                <td>{{$equipment->name}}</td>
                <td>{{$equipment->price}}</td>
            </tr>
    @endforeach
    </table>
    @endif
</body>
</html>
