<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Print Barcode</title>
    <style>
        * {
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .imag-logo{
            height: 23px;
            width: 23px;
        }
        td,
        tr,
        table {
            border-collapse: collapse;
            display: inline-grid;
            padding-bottom: 8px;
            margin-right: 0px;
        }
        td.description,
        th.description {
            width: 123px;
            max-width: 147px;
        }
        tbody{
            margin-left: 16px;
        }
        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }
        .centered {
            text-align: center;
            align-content: center;
        }
        .ticket {
            width: 165px;
            max-width: 165px;
        }
        img {
            max-width: inherit;
            width: inherit;
            color: black;
            max-height: 21px;
        }
        @media print {
            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }
        table {
            position:relative;
            display:table;
            table-layout:fixed;
            padding-top:50px;
            padding-bottom:50px;
            margin-left:15px;
            width: 100%;
            height:auto;
        }
        @media print {
            html, body {
                height: 99%;
            }
        }
        .print {
            page-break-after: auto;
        }

    </style>
</head>
<body>
<div class="ticket" >
    @for ($i = 0; $i < $quantity; $i++)
        <table>
            <tr>
                <th>
                        <img src="{{ asset('images/whiteLogo.png') }}" alt="" style="    max-width: 65%;">
                </th>
                <th style="font-size: 12px;" class=""> {{$product->name}} </th>
                <th class="description">
                    @php
                        echo DNS1D::getBarcodeSVG($product->product_code, 'C128A',1.1,40);
                    @endphp
                </th>
                <th style=""> <span style="font-size: 18px;"> Tk.{{$product->sell_price}} {{get_settings('currency_symbol')}} + VAT</span></th>
            </tr>
        </table>
    @endfor
</div>
<button id="btnPrint" class="hidden-print">Print</button>
<script src="{{asset('js/print.js')}}"></script>
</body>
</html>
