<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name','App') }}</title>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
@yield('content')
</body>
</html>
