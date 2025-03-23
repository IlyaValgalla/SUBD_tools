{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--    <style> .is-invalid { color: #ff2d20;}</style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h2>Редактирование товара</h2>--}}
{{--<form method="post" action="{{ url('equipment/update/' .$equipment->id) }}">--}}
{{--    @csrf--}}
{{--    @method('PUT') <!-- Добавляем метод PUT для обновления -->--}}

{{--    <!-- Поле "Наименование" -->--}}
{{--    <label>Наименование</label>--}}
{{--    <input type="text" name="name" value="{{ old('name', $equipment->name) }}" />--}}
{{--    @error('name')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}

{{--    <!-- Поле "Цена" -->--}}
{{--    <label>Цена</label>--}}
{{--    <input type="text" name="price" value="{{ old('price', $equipment->price) }}" />--}}
{{--    @error('price')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}

{{--    <!-- Поле "Категория" -->--}}
{{--    <label>Категория</label>--}}
{{--    <select name="category_id">--}}
{{--        <option value="" disabled>Выберите категорию</option>--}}
{{--        @foreach($categories as $category)--}}
{{--            <option value="{{ $category->id }}"--}}
{{--                {{ (old('category_id', $equipment->category_id) == $category->id) ? 'selected' : '' }}>--}}
{{--                {{ $category->name }}--}}
{{--            </option>--}}
{{--        @endforeach--}}
{{--    </select>--}}
{{--    @error('category_id')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}

{{--    <!-- Поле "Количество на складе" -->--}}
{{--    <label>Количество на складе</label>--}}
{{--    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock', $equipment->quantity_in_stock) }}" />--}}
{{--    @error('quantity_in_stock')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}

{{--    <!-- Кнопка отправки формы -->--}}
{{--    <input type="submit" value="Обновить">--}}
{{--</form>--}}
{{--</body>--}}
{{--</html>--}}



@extends('layout')
@section('content')
    <div class="row justify-content-center">
        <div class="col-4">
            <h2>Редактирование товара</h2>
            <form method="post" action="{{ url('equipment/update/' . $equipment->id) }}">
                @csrf
                @method('PUT') <!-- Добавляем метод PUT для обновления -->

                <!-- Поле "Наименование" -->
                <div class="mb-3">
                    <label for="name" class="form-label">Наименование</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="@if(old('name')) {{old('name')}} @else {{$equipment->name}} @endif"/>
                    <div id="nameHelp" class="form-text">Введите наименование</div>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Поле "Цена" -->
                <div class="mb-3">
                    <label for="price" class="form-label">Цена</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror"
                           id="price" name="price" value="@if(old('price')) {{old('price')}} @else {{$equipment->price}} @endif"/>
                    <div id="priceHelp" class="form-text">Введите цену инструмента</div>
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Поле "Категория" -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Категория</label>
                    <select class="form-select @error('category_id') is-invalid @enderror"
                            id="category_id" name="category_id">
                        <option value="" disabled>Выберите категорию</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @if (old('category_id')) @if(old('category_id') == $category->id) selected @endif
                            @else
                                @if($equipment->category_id == $category->id) selected @endif
                            @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div id="category_idHelp" class="form-text">Введите категорию товара</div>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Поле "Количество на складе" -->
                <div class="mb-3">
                    <label for="quantity_in_stock" class="form-label">Количество на складе</label>
                    <input type="number" class="form-control @error('quantity_in_stock') is-invalid @enderror"
                           id="quantity_in_stock" name="quantity_in_stock"
                           value="@if(old('quantity_in_stock'))
                           {{old('quantity_in_stock')}} @else {{$equipment->quantity_in_stock}} @endif"/>

                    <div id="quantity_in_stockHelp" class="form-text">Введите количество интсрументов на складе </div>
                    @error('quantity_in_stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Кнопка отправки формы -->
                <button type="submit" class="btn btn-primary">Обновить</button>
            </form>
        </div>
    </div>
@endsection
