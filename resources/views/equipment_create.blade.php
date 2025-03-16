<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>605-11</title>
    <style>  .is-invalid { color: #ff2d20;}   </style>
</head>
<body>
<h2>Добавление товара</h2>
<form method="post" action="{{ url('equipment') }}">
@csrf
    <label>Наименование</label>
    <input type="text" name="name" value="{{old('name')}}">
    @error('name')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
<br>
    <label>Цена</label>
    <input type="text" name="price" value="{{old('price')}}">
    @error('price')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
<br>
    <label>Категория</label>
    <select name="category_id">
        <option value="" disabled selected>Выберите категорию</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
<br>
    <label>Количество на складе</label>
    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock') }}">
    @error('quantity_in_stock')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
    <br>
    <input type="submit">
</form>
</body>
</html>
