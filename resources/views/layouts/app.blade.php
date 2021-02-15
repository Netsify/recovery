<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Получение пароля в СДО</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">

    @include('layouts.metrika')
{{--    @include('layouts.cleversite')--}}
    @include('layouts.jivosite')
</head>
<body>
<div id="app">
    @include('layouts.header')

    <main class="py-4">
        @yield('content')
        <div id="app">
            <input type="text" v-model="message" placeholder="отредактируй меня">
            <p>Введённое сообщение: @{{ message }}</p>
        </div>
    </main>

    @include('layouts.footer')
</div>
{{--<script type="text/javascript">--}}
{{--    new Vue({--}}
{{--        el: '#app',--}}
{{--        data: {--}}
{{--            message: 'hbhhbgb'--}}
{{--        }--}}
{{--    })--}}
{{--</script>--}}
</body>
</html>
