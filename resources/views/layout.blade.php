<!DOCTYPE html>
<html>
    <head>
        <title>@yield('page_title')</title>
        <meta name="viiewport" content="width=device-width, initial-scale=1.0" />
        <meta name="token" content="{!! csrf_token() !!}" />

        <link rel="stylesheet" href="{!! asset('css/bootstrap.css') !!}" />

        <script src="{!! asset('js/jquery.min.js') !!}"></script>
        <script src="{!! asset('js/bootstrap.js') !!}"></script>
        <script src="{!! asset('js/bootstrap.bundle.js') !!}"></script>

        @yield('header_styles')
    </head>
    <body>
    <header id="header" class="mb-2"></header>
    @yield('content')
    <footer></footer>
    </body>
    @yield('footer_scripts')
</html>




