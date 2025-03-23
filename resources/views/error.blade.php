{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>605-11</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--    <h2>{{ $message }}</h2>--}}
{{--    <a href="{{url('equipment')}}">1) Вернуться к списку товаров</a>--}}
{{--    <br>--}}
{{--    <br>--}}
{{--    <a href="{{url('category')}}">2) Вернуться к спику категорий</a>--}}
{{--</body>--}}
{{--</html>--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERROR Kimlya60511</title>
</head>
<body>
<div class="container" style="margin-top: 80px">
    @error('email')
    <div class="alert alert-warning" role="alert">
        {{ $message }}
    </div>
    @enderror
    @error('password')
    <div class="alert alert-warning" role="alert">
        {{ $message }}
    </div>
    @enderror
    @error('error')
    <div class="alert alert-warning" role="alert">
        {{ $message }}
    </div>
    @enderror
    @error('success')
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
    @enderror
</div>
</body>
</html>
