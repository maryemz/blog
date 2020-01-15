<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fontawesome.min.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app">
        
        <main-vue></main-vue>

    <script src="{{ asset('js/app.js') }}" type="application/javascript"></script>
</body>
</html>
