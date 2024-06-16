<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="{{ asset('public/images/Icon.png') }}">
    <title>@yield('title')</title>
    @include('layouts.head')
    @stack('css')

</head>

<body>


    <div class="content">
        @yield('content')
    </div>

    @include('layouts.footer')
</body>
@show

@stack('js')


</html>
