<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Server Issue</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->

    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/square/blue.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <style>
        body {
            background-color: #231F20 !important;
            font-family: "Roboto Light";
        }

        .login-box-body,
        .register-box-body {
            background: #413D3E !important;
            padding: 20px;
            border-top: 0;
            color: #666;
            border-radius: 10px;

        }

        label {
            color: #FFFFFF !important;
        }

        .form-control {
            border-width: 0 0 2px;
            background-color: #413D3E !important;
            color: #fff !important;
        }

        element.style {
            box-shadow: none;
            border-width: 1px;
            border-radius: 12px;
            width: 142%;
            text-align: center;
        }

        .btn.btn-flat {
            border-radius: 0;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            border-width: 1px;
        }

        .btn-warning {
            background-color: #F56A27;
            border-color: #F56A27;
        }

        .selectWrapper {
            border-radius: 8px;
            display: inline-block;
            overflow: hidden;
            background: #F56927;
            border: 1px solid #F56927;
            outline: none;
            margin-top: 30px;
        }

        .selectBox {
            width: 140px;
            height: 30px;
            border: 0;
            outline: none;
            color: white;
            background-color: #A14A16;
        }
    </style>
</head>

<body class="hold-transition login-page">

    <img src="{{ asset('images/newserverError.jpg') }}" alt="">
    <script src="{{ asset('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

</body>

</html>
