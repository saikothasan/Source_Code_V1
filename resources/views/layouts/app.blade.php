<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="{{ asset('public/images/Icon.png') }}">
    <title>@yield('title')</title>

    @include('layouts.head')
    @stack('css')
    @yield('customcss')
    <style>
        .skin-blue .main-header .navbar {
            position: fixed;
            left: 0;
            right: 0;
        }

        .skin-blue .main-header .logo {
            position: fixed;
        }

        .sidebar-mini.sidebar-collapse .main-sidebar .sidebar .sidebar-menu {
            width: 50px;
        }

        .sidebar-mini .main-sidebar .sidebar,
        .sidebar-mini.sidebar-collapse .main-sidebar .sidebar {
            height: 100vh !important;
            position: fixed !important;
            width: 230px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        .main-sidebar::-webkit-scrollbar {
            width: 0px;
            /* Adjust the width as needed */
        }

        .sidebar::::-webkit-scrollbar {
            display: none !important;
            width: 0px;
        }

        .sidebar.scrollable {
            display: none !important;
            width: 0px;
        }

        @media only screen and (max-width:767px) {
            .skin-blue .main-header .navbar {
                top: 50px;
            }
        }
    </style>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @auth


            @include('layouts.header')
            @if (isSupplier())
                @include('layouts.supplierSidebar')
            @else
                @include('layouts.sidebar')
            @endif
        @endauth



        <x-loader></x-loader>
        @section('content')

        @show
        @stack('js')
        @auth
            @include('layouts.footer')
        @endauth
        <script type="text/javascript">
            function printDiv(divName) {
                let printContents = document.getElementById(divName).innerHTML;
                let originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;


            }

            function preLoader(loader) {
                if (loader === true) {
                    $('#apploader').show();
                } else if (loader === false) {
                    $('#apploader').hide();
                } else {
                    $('#apploader').show();
                    setTimeout(() => $('#apploader').hide(), 500);
                }
            }
        </script>
        @yield('customjs')
    </div>

</body>

</html>
