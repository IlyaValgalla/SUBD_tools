<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
    <style> .is-invalid { color: #ff2d20;}</style>
</head>
<body>
<h2>Редактирование товара</h2>
<form method="post" action="{{ url('equipment/update/' .$equipment->id) }}">
    @csrf
    @method('PUT') <!-- Добавляем метод PUT для обновления -->

    <!-- Поле "Наименование" -->
    <label>Наименование</label>
    <input type="text" name="name" value="{{ old('name', $equipment->name) }}" />
    @error('name')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
    <br>

    <!-- Поле "Цена" -->
    <label>Цена</label>
    <input type="text" name="price" value="{{ old('price', $equipment->price) }}" />
    @error('price')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
    <br>

    <!-- Поле "Категория" -->
    <label>Категория</label>
    <select name="category_id">
        <option value="" disabled>Выберите категорию</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ (old('category_id', $equipment->category_id) == $category->id) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
    <br>

    <!-- Поле "Количество на складе" -->
    <label>Количество на складе</label>
    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $equipment->quantity_in_stock) }}" />
    @error('quantity_in_stock')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
    <br>

    <!-- Кнопка отправки формы -->
    <input type="submit" value="Обновить">
</form>
</body>
</html>
