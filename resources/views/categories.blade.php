<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
</head>
<body>
    <h2>Список категорий:</h2>
    <table border="1">
        <thead>
            <td>id</td>
            <td>Наименование</td>
            <td>Действия</td>
        </thead>
    @foreach($categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td><a href="{{url('category/destroy/'.$category->id)}}">Удалить</a>
                    <a href="{{url('category/edit/'.$category->id)}}">Редактировать</a>
            </tr>
    @endforeach
    </table>
    <br>
    <a href='/category/create'>
        <button type="button">Создать категорию</button>
    </a>

</body>
</html>
