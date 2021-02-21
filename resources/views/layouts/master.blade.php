<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
    @include('partials.head')
</head>
<body class="gradient">
@include('partials.header')

<div class="content m-auto">
    @yield('content')
</div>

@include('partials.footer')
@include('partials.scripts')
@yield('javascript')
</body>
</html>
