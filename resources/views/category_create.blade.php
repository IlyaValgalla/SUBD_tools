<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
    <style>  .is-invalid { color: #ff2d20;}   </style>
</head>
<body>
<h2>Добавление категории товара</h2>
<form method="post" action="{{ url('category') }}">
    @csrf
    <label>Наименование</label>
    <input type="text" name="name" value="{{old('name')}}">
    @error('name')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
    <br>
    <input type="submit">
</form>
</body>
</html>
