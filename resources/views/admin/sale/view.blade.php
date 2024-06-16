@extends('layouts.app')
@section('title', 'Sale ' . $sale->invoice_code)
@section('content')
    @push('css')
        <style>
            .option {
                padding-top: 20px;
            }

            .none-border {
                border: none !important;
            }

            .corner {
                border-radius: 7px;
                text-align: center;
            }

            .selectBox {
                border-radius: 4px;
                border: 1px solid #AAAAAA;
            }


            .invoice-font {
                font-size: 12px;
                /*font-family: 'Times New Roman';*/
            }

            td.description,
            th.description {
                width: 120px;
                max-width: 120px;
            }

            td.mrp,
            tr.mrp {
                width: 30px;
            }

            td.quantity,
            th.quantity {
                text-align: center;
                width: 40px;
                max-width: 40px;
                word-break: break-all;
            }

            td.price,
            th.price {
                text-align: right;
                /* width: 40px; */
                max-width: 40px;
                word-break: break-all;
            }

            .bill {
                border: 2px solid black;
                background-color: #000;
                color: #ffff;
                border-radius: 8px;
                padding: 4px;
                text-align: center;

            }

            .centered {
                text-align: center;
                align-content: center;
            }

            .left {
                text-align: right;
            }

            .ticket {
                width: 280px;
            }

            .text-end {
                margin-left: 56px;
            }

            .image {
                max-width: inherit;
                width: inherit;
                width: 85%;
            }


            .footer {
                text-align: center;
            }

            .sale-row {
                display: flex;
                font-weight: 600;
            }

            @media print {

                .hidden-print,
                .hidden-print * {
                    display: none !important;
                }
            }

            .invoice {
                font-size: 14px;
                line-height: 1.42857143;
                color: #000 !important;
                background-color: #fff;
            }

            .barcode {
                width: 40%;
                margin-top: 10px;
            }

            .invoice-border {
                border: 2px solid #000;
                padding: 10px;
                border-radius: 10px;
            }

            .selectBoxmargin {
                margin-top: 31px
            }

            .selectBoxmargin2 {
                margin-top: 24px;
            }

            .example-table tr:nth-child(2n+1) {
                background-color: #ddd;
            }

            .example-table tr:nth-child(2n+0) {
                background-color: #eee;
            }

            .table-outline {
                border: 2px solid rgb(38, 169, 224);
                padding: 0px;
                border-radius: 10px;
            }

            .table-head {
                background-color: rgb(38, 169, 224);
                color: #fff;
            }

            .image-size {
                width: 1.5em;
                height: 1.5em;
            }

            .form-group {
                color: #000000;
            }

            .form-control {
                border-radius: 7px;
                box-shadow: none;
                border-color: #06cdffd6 !important;
                height: 36px !important;
                color: #000000 !important;
            }

            .sale-quantity {
                display: block;
                width: 100%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #000;
                background-color: #0000;
                background-image: none;
                border: 1px solid #ccc;
                border-color: #f9f9f9d6 !important;
                outline: -webkit-focus-ring-color auto 0px;
            }

            .paid-input {
                display: block;
                width: 100%;
                height: 34px;
                padding: 6px 12px;
                font-size: 14px;
                line-height: 1.42857143;
                color: #000;
                background-color: #0000;
                background-image: none;
                border: 1px solid #ccc;
                outline: -webkit-focus-ring-color auto 0px;
            }

            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            .vat {
                font-size: 14px;
                line-height: 1.42857143;
                color: #000;
                background-color: non;
                background-image: none;
                border: none;
                border-color: #f9f9f9d6 !important;
                outline: -webkit-focus-ring-color auto 0px;
            }
        </style>
    @endpush
    <div class="content-wrapper" id="sale-print" style="padding-top:2%;">
        <x-sale.new-sale-view :sale="$sale"></x-sale.new-sale-view>




        <div class="text-center" style="margin-top:2%; padding-bottom:2%">
            <button onclick='printDiv("sale-print")' class="btn text-black print pointer hidden-print"
                style=" margin-right:20px; color: black;border-color: #000000;background: white;">Print</button>
            <a href="{{ route('sale.download', $sale->id) }}">
                <button type="submit" class="btn text-black print pointer hidden-print"
                    style="color: black;border-color: #000000;background: white;"> Download</button>
            </a>
        </div>

    </div>
@endsection
