<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ColorFul | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome2.min.css') }}">
    <!-- Theme style -->
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
            border-radius: ;

        }

        .box-body {
            background: #413D3E;
            color: white;
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

        .mt-2 {
            margin-top: 2%;
        }
    </style>
</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <div style="color: white;">
            <x-current-date-time></x-current-date-time>
        </div>
        <div class="login-logo">
        </div>
        <center>
            <a href="{{ URL::to('/') }}"> <img src="{{ asset(getSetting('site_logo', 'images/logoheader.png')) }}"
                    style="width: 280px;height: 69px;"></a>
        </center>
        <form action="{{ route('login') }}" method="post">
            <div style="text-align: center;">

                <div class="selectWrapper text-center row" style="">
                    <select class="selectBox" style="text-align: center;" name="section_id" id="section_id">
                        @foreach (getSections() as $value)
                            <option value="{{ $value->id }}"
                                {{ intval(old('section_id')) == $value->id ? 'selected' : '' }}>
                                {{ strtoupper($value->name) }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <div class="login-box-body" style="margin-top: 30px">
                @include('includes.errormessage')
                @csrf
                <div class="form-group has-feedback">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email" autocomplete="off"
                        value="{{ old('email') }}" name="email" placeholder="Enter Email">
                </div>
                <div class="form-group has-feedback">
                    <label>Password</label>
                    <input type="password" class="form-control" id="password" autocomplete="off" name="password"
                        placeholder="Enter Password">
                    <div class="text-right">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Forgot password?</a><br>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-warning btn-block btn-flat"
                            style="
                    box-shadow: none;
                    border-width: 1px;
                    border-radius: 12px;width: 142%;
                        text-align: center;">
                            LOGIN
                        </button>
                    </div>
                    <div class="col-xs-4">
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </form>
        @if (env('APP_MODE') == 'demo')
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10">
                        <span> Email : admin@gmail.com</span><br>
                        <span>Password : 12345678</span>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn " style="background:#777" onclick="adminLogin('admin')"><i
                                class="fa fa-copy"></i>
                        </button>
                    </div>
                    <div class="">

                        <div class="col-md-10 mt-2">
                            <span> Email : supplier@gmail.com</span><br>
                            <span>Password : 12345678</span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <button class="btn btn " style="background:#777" onclick="adminLogin('supplier')"><i
                                    class="fa fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="">

                        <div class="col-md-10 mt-2">
                            <span> Email : branch@gmail.com</span><br>
                            <span>Password : 12345678</span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <button class="btn btn " style="background:#777" onclick="adminLogin('branch')"><i
                                    class="fa fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>


            </div>
        @endif
    </div>


    <script src="{{ asset('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}">
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>
    @if (env('APP_MODE') == 'demo')
        <script>
            function adminLogin(val) {
                if (val == 'admin') {
                    jQuery('#email').val('admin@gmail.com');
                    jQuery('#password').val('12345678');
                    jQuery('#section_id').val(1);
                } else if (val == 'branch') {
                    jQuery('#email').val('branch@gmail.com');
                    jQuery('#password').val('12345678');
                    jQuery('#section_id').val(1);
                } else {
                    jQuery('#email').val('supplier@gmail.com');
                    jQuery('#password').val('12345678');
                    jQuery('#section_id').val(3);
                }

                toastr.success('Copied successfully!', 'Success!', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        </script>
    @endif
</body>

</html>
