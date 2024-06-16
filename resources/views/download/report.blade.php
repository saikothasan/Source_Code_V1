<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$report['report_name'] . ' '.$report['report_id'] }}</title>

    <style>
        @font-face {
            font-family: RobotoBold;
            src: url('/font/Roboto/Roboto-Bold.ttf');
        }

        @font-face {
            font-family: RobotoRegular;
            src: url('/font/Roboto/Roboto-Regular.ttf');
        }

        @font-face {
            font-family: RobotoLight;
            src: url('/font/Roboto/Roboto-Light.ttf');
        }

        html body {
            font-family: RobotoBold, RobotoRegular, RobotoLight, serif !important;
        }

        div {
            display: block;
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-md-2 {
            width: 16.66666667%;
        }

        .col-md-8 {
            width: 66.66666667%;
        }

        .signature-generator, .autority-section, .footer-section {
            text-align: center;
        }

        .spacer {
            margin-top: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }


        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9;
            color: black !important;
        }

        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }

        .text-center {
            text-align: center;
        }

        .table-responsive {
            min-height: .01%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }

        table {
            background-color: transparent;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        table {
            display: table;
            box-sizing: border-box;
            text-indent: initial;

        }

        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            border-top: 1px solid #f4f4f4;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        td {
            border: 1px solid black !important;
        }

        td, th {
            padding: 0;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        td {
            display: table-cell;
            vertical-align: inherit;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9;
            color: black !important;
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .second-section {
            text-align: center;
        }

        .header-logo img {
            width: 40%;
        }

        .header tr {
            background: black !important;
            color: white;
            border: 1px solid black !important;

        }

        .header th {
            border-bottom: 2px solid #000000 !important;
        }


        .autority-section hr {
            margin-top: 20px;
            margin-bottom: 10px;
            border: 0;
            border-top: 2px solid #1d1c1c;
            width: 50%;
        }

        .signature-generator, .autority-section, .footer-section {
            text-align: center;
        }

        .confirm-section p {
            font-size: 16px;
        }

        .confirm-section {
            margin-top: 7% !important;
            margin-bottom: 5% !important;
            text-align: center !important;
        }

        .confirm-section hr {
            margin-top: 20px !important;
            margin-bottom: 5px !important;
            border: 0 !important;
            border-top: 2px solid #000 !important;
        }

        .signature-generator hr {
            margin-top: 20px;
            margin-bottom: 5px;
            border: 0;
            border-top: 2px solid #000;
        }

        .second-section h3 strong {
            text-decoration: underline;
        }

        .box-header {
            border: 1px solid #00c0ef;
            border-radius: 17px;
        }

        .groupedInput {
            border: 1px solid #e1cdcd;
            border-radius: 7px;
            /*border-radius: 10px;*/
        }

        footer {
            margin-top: 5%;
        }

        .spacer {
            margin-top: 20px;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }


        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light';
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f9f9f9;
            color: black !important;
        }


        .image-size {
            width: 1.5em;
            height: 1.5em;
        }
        @media (min-width: 992px)
            .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
                float: left;
            }

            .card-sale {
                border: 2px solid #1cb24d;
            }

            .card-cost {
                border: 2px solid #F15A29;
            }

            .card-blance {
                margin-top: 5%;
                border: 2px solid gray;
            }

            .card-other-cost {
                margin-top: 4%;
                border: 2px solid #ED1E24;
                background: #ED1E24;
            }

            .card-profit {
                border: 2px solid rgb(0, 118, 150);
            }

            .card-header,
            .card-footer {
                padding: 10px;
                text-align: center;
                color: white;
            }

            .card-sale .card-header,
            .card-footer {
                background: #1cb24d;
            }

            .card-sale {
                background: #1cb24d;
            }

            .delivery {
                padding: 18px;
                border-bottom: 1px solid black;
            }

            .card-profit {
                background: rgb(0, 118, 150);
            }

            .card-blance {
                background: gray;
            }

            .card-cost {
                background: #F15A29;
            }

            .for-title-branch {
                font-size: 19px;
                text-decoration: underline;
            }

            .list-group-item {
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                /*border-bottom: 3px solid #a59e9e;*/
            }

            .list-group-item p {
                font-family: 'Source Sans Pro', sans-serif;
            }

            .list-group {
                margin-bottom: 0;
                background: white;
            }

            .amount-margin {
                margin-top: 18%;
            }

            .total_pices {
                font-family: 'Source Sans Pro', sans-serif;
                font-size: 16px;
            }

            .cost-row {
                font-family: 'Source Sans Pro', sans-serif;
                font-size: 16px;
            }

            .paddin-dicress {
                padding-right: 0px;
                padding-left: 10px;
            }
    </style>
</head>
<body>
@if($report['report_name']=='Sales Report')
    <x-report.sale-report :report="$report"></x-report.sale-report>
@endif
@if($report['report_name']=='Stock Report')
    <x-report.stock-report :report="$report"></x-report.stock-report>
@endif
@if($report['report_name']=='C.R Master Report')
    <x-report.cr-master-report :report="$report"></x-report.cr-master-report>
@endif
</body>
</html>

