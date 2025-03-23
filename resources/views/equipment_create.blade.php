{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--    <style>  .is-invalid { color: #ff2d20;}   </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h2>Добавление товара</h2>--}}

{{--<form method="post" action="{{ url('equipment') }}">--}}
{{--@csrf--}}
{{--    <label>Наименование</label>--}}
{{--    <input type="text" name="name" value="{{old('name')}}">--}}
{{--    @error('name')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--<br>--}}
{{--    <label>Цена</label>--}}
{{--    <input type="text" name="price" value="{{old('price')}}">--}}
{{--    @error('price')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--<br>--}}
{{--    <label>Категория</label>--}}
{{--    <select name="category_id">--}}
{{--        <option value="" disabled selected>Выберите категорию</option>--}}
{{--        @foreach($categories as $category)--}}
{{--            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>--}}
{{--                {{ $category->name }}--}}
{{--            </option>--}}
{{--        @endforeach--}}
{{--    </select>--}}
{{--    @error('category_id')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--<br>--}}
{{--    <label>Количество на складе</label>--}}
{{--    <input type="number" name="quantity_in_stock" value="{{ old('quantity_in_stock') }}">--}}
{{--    @error('quantity_in_stock')--}}
{{--    <div class="is-invalid">{{ $message }}</div>--}}
{{--    @enderror--}}
{{--    <br>--}}
{{--    <input type="submit">--}}
{{--</form>--}}
{{--</body>--}}
{{--</html>--}}

{{----}}


@extends('layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-4">
    <form method="post" action={{ url('equipment') }}    >
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Наименование</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" aria-describedby="nameHelp" value={{ old('name') }}>
            <div id="nameHelp" class="form-text">Введите наименование товара (макс. 150 символов) </div>
            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Цена</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror"
                   id="price" name="price" aria-describedby="priceHelp" value={{ old('price') }}>
            <div id="priceHelp" class="form-text">Введите цену товара в рублях (целое число) </div>
            @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Категория</label>
            <select class="form-select" id="category" name="category_id" aria-describedby="categoryHelp" value={{ old('$category_id') }}>
                <option style="..."
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                            @if(old('category_id') == $category->id) selected
                        @endif>{{$category->name}}
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
        <div class="mb-3">
            <label for="price" class="form-label">Количество на складе</label>
            <input type="number" class="form-control @error('quantity_in_stock') is-invalid @enderror"
                   id="price" name="quantity_in_stock" aria-describedby="quantity_in_stockHelp" value={{ old('quantity_in_stock') }}>
            <div id="quantity_in_stockHelp" class="form-text">Введите количество интсрументов на складе </div>
            @error('quantity_in_stock')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
    </div>
</div>
@endsection
