<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
</head>
<body>
<h2>Информация о пользователях</h2>
    <table border="1">
        <tr>
            <td>id</td>
            <td>Имя</td>
            <td>Фамилия</td>
            <td>Номер телефона</td>
            <td>email</td>
        </tr>

        @foreach($users as $User)
            <tr>
                <td>{{$User->id}}</td>
                <td>{{$User->name}}</td>
                <td>{{$User->last_name}}</td>
                <td>{{$User->phone_number}}</td>
                <td>{{$User->email}}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
