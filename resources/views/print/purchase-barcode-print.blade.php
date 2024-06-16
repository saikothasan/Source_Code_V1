<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Barcode Print</title>
    <style>
        * {
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .imag-logo {
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
            width: 240px;
            max-width: 240px;
        }

        tbody {
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
            width: 240px;
            max-width: 240px;
        }

        img {
            max-width: inherit;
            width: inherit;
            color: black;
            max-height: 50px;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }

        table {
            position: relative;
            display: table;
            table-layout: fixed;
            padding-top: 50px;
            padding-bottom: 50px;
            margin-left: 15px;
            width: 100%;
            height: auto;
        }

        @media print {

            html,
            body {
                height: 99%;
            }
        }

        .print {
            page-break-after: auto;
        }
    </style>
</head>

<body onload="window.print();">
    <div class="ticket">
        @foreach ($purchase->purchaseDetails as $value)
            {{--        {{dd($value)}} --}}
            @if (isset($value->productVariations->variantValues))
                @php
                    $variantName = collect($value->productVariations->variantValues)
                        ->pluck('variantValueName.variation_value')
                        ->implode('-');
                    $sell_price = $value->productVariations->variant_price;
                    $barcode = $value->productVariations->variant_barcode;
                    $sku = $value->productVariations->variant_sku;
                    
                @endphp
            @else
                @php
                    $sell_price = $value->product->sell_price;
                    $barcode = $value->product->product_code;
                    $variantName = null;
                    $sku = $value->product->product_sku;
                @endphp
            @endif
            @for ($i = 0; $i < $value->quantity; $i++)
                <table>
                    <tr>
                        <th>
                            <img src="{{ asset('images/logo.png') }}" alt="" style="    max-width: 65%;">
                        </th>
                        <th style="font-size: 12px;" class=""> {{ $value->product->name }}@if (isset($variantName))
                                -{{ $variantName }}
                            @endif

                        </th>
                        <th> <span>&nbsp;{{ $sku }}</span></th>
                        <th class="description">

                            @php
                                echo DNS1D::getBarcodeSVG($barcode, 'C128A', 1.7, 40);
                            @endphp

                        </th>
                        <th style=""><span style="font-size: 18px;"> Tk.{{ $sell_price }}
                                {{ get_settings('currency_symbol') }} + VAT</span></th>
                    </tr>
                </table>
            @endfor
        @endforeach
    </div>
    <button id="btnPrint" class="hidden-print">Print</button>
    <script src="{{ asset('js/print.js') }}"></script>
</body>

</html>
