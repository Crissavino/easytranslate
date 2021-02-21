<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title')</title>
    @include('partials.head')
</head>
<body class="gradient">
@if(isset($success) && !$success)
    <div class="col-10 m-auto mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error getting exchange rates!</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@include('partials.header')

<div class="content m-auto">
    @yield('content')
</div>

@include('partials.footer')
@include('partials.scripts')
@yield('javascript')
</body>
</html>
