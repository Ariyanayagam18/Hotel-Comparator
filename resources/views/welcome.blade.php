<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body class="antialiased">
        @include('layouts/header')
        @include('homepage')
        @include('layouts/footer')
    </body>
</html>

