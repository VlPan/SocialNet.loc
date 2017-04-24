<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Styles -->

</head>
<body>

@if(Auth::user() == true)
@include('includes.header')
@endif

<div class="container">
    @yield('content')
</div>

<script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/index.js') }}" type="text/javascript"></script>
</body>
</html>
