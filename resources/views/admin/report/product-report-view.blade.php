@extends('layouts.app')
@section('title', 'Product Report')
@push('css')
    <style>
        .container {
            text-align: center;
            border: 6px solid;
            font-family: normal;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
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

        td {
            border: 1px solid black !important;
        }

        .autority-section hr {
            margin-top: 20px;
            margin-bottom: 10px;
            border: 0;
            border-top: 2px solid #1d1c1c;
            width: 50%;
        }

        .confirm-section p {
            font-size: 16px;
        }

        .confirm-section {
            margin-top: 7%;
            margin-bottom: 5%;
            text-align: center;
        }

        .confirm-section hr {
            margin-top: 20px;
            margin-bottom: 5px;
            border: 0;
            border-top: 2px solid #000;
        }

        .header-title hr {
            margin-top: 20px;
            margin-bottom: 5px;
            border: 0;
            border-top: 2px solid #000;
            margin-top: 20px;
            margin-bottom: 10px;
            border: 0;
            border-top: 3px solid #1d1c1c;
            width: 31%;
        }

        .delivery .header-title hr {
            margin-top: 20px;
            margin-bottom: 5px;
            border: 0;
            border-top: 2px solid #000;
            margin-top: 10px;
            margin-bottom: 10px;
            border-top: 3px solid #1d1c1c;
            width: 16%;
        }

        .product-section {
            margin-top: 4%;
        }

        .generator-section,
        .product-table {
            margin-top: 3%;
        }

        .signature-generator hr {
            margin-top: 20px;
            margin-bottom: 5px;
            border: 0;
            border-top: 2px solid #000;
        }

        .purchase hr {
            margin-top: 9px;
            margin-bottom: 17px;
            border: 0;
            width: 100%;
            border-top: 3px solid #000;
        }

        .transfer hr {
            margin-top: 9px;
            margin-bottom: 17px;
            border: 0;
            width: 100%;
            border-top: 3px solid #000;
        }

        .second-section h3 strong {
            text-decoration: underline;
        }

        footer {
            margin-top: 5%;
        }


        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f9f9f9;
            color: black !important;
        }

        .tbody td {
            color: black;
        }

        .card-sale .card-header,
        .card-footer {
            background: #1cb24d;
        }

        .list-group-item p {
            font-family: 'Source Sans Pro', sans-serif;
        }

        .row {
            display: flex;
        }

        .col-md-3 {
            width: 25%;
        }

        .col-md-8 {
            width: 66.66666667%;
        }

        .col-md-2 {
            width: 16.66666667%;
        }

        .col-md-4,
        .col-md-6 {
            width: 50%;
        }

        .product-name {
            background: #E9E9E9;
            padding: 2px;
        }

        .purchase {
            text-align: left;

        }

        .transfer {
            text-align: right;
        }

        .delivery {
            margin: 3%;
        }
    </style>
@endpush
@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard" id="report-print">
                <div class="container" id="report">

                </div>
            </div>
            <div class="text-center" style="margin: 2%;">
                <button onclick='printDiv("report-print")' class="btn text-black print pointer hidden-print"
                    style=" margin-right:20px; color: black;border-color: #000000;background: white;">Print
                </button>
            </div>
        </section>

    </div>
@endsection

@push('js')
    <script>
        async function getReport() {
            preLoader(true);
            await $.ajax({
                url: "{{ route('report-history.get', $report->id) }}",
                type: "GET",
                success: function(data) {
                    $("#report").html(data);
                    preLoader(false);
                }
            })
        }

        $(document).ready(function() {
            getReport()
        });
    </script>
@endpush
