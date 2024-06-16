<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dist/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/iCheck/flat/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .image img {
            width: 102px;
            border-radius: 50px;
        }

        .image-sm {
            width: 56px;
            border-radius: 25px;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .image-div {
            text-align: right;
            padding: 100px;
            margin-top: -160px;
        }

        .right-image {
            height: 50%;
            width: 19%;
            border: 4px solid #FF7200;
            border-radius: 100%;
        }

        .heading {
            margin-top: -150px;
        }

        .fa-fw {
            width: 2.285714em;
            text-align: center;
            font-size: 24px;
            color: gray;
        }

        .hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 3px solid black;
        }

        .text-color {
            style="color: gray";
        }

        .table-spacing {
            font-family: 'Roboto Light';
            padding-top: 10px;
        }

        .sidepanel {
            height: auto;
            width: 0;
            position: absolute;
            z-index: 1;
            background-color: rgb(75, 75, 113);
            overflow-x: hidden;
            transition: 0.5s;
            margin-top: -57px;
        }

        .white-text {
            color: #ffffff;
        }

        .modal-radious {
            border: 0px solid #ededed;
            border-radius: 25px;
        }

        .custom-modal-header {
            background-image: linear-gradient(to right, #EC1D24, #e6e691);
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
        }

        .custom-modal-footer {
            background-color: rgb(255, 226, 201);
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .tablet {
            border: 2px solid #0a0606;
            border-radius: 8px;
            background-color: black;
            color: white;
        }

        .custom-circle {
            font-size: 50px;
            color: rgb(255, 77, 0);
        }

        .custom-footer {
            padding: 15px;
            text-align: right;
        }

        .d-flex {
            display: flex;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row text-center">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        @if ($cash_drawer->cash_type === 0)
                            <x-cash-in.cash-in :cashHistory="$cash_drawer"></x-cash-in.cash-in>
                        @elseif($cash_drawer->cash_type === 1)
                            <x-payment.payment :cashHistory="$cash_drawer"></x-payment.payment>
                        @elseif($cash_drawer->cash_type === 2 || $cash_drawer->cash_type === 5)
                            <x-transfer-money.transfer :cashHistory="$cash_drawer"></x-transfer-money.transfer>
                        @endif
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
    </div>
    </section>
    </div>
</body>

</html>
