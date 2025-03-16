<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
    <style> .is-invalid { color: #ff2d20;}</style>
</head>
<body>
<h2>Редактирование категории товара</h2>
<form method="post" action="{{ url('category/update/' .$category->id) }}">
    @csrf
    @method('PUT') <!-- Добавляем метод PUT для обновления -->

    <!-- Поле "Наименование" -->
    <label>Наименование</label>
    <input type="text" name="name" value="{{ old('name', $category->name) }}" />
    @error('name')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
    <br>

    <!-- Кнопка отправки формы -->
    <input type="submit" value="Обновить">
</form>
</body>
</html>
