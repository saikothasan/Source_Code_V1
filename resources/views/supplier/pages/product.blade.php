@extends('layouts.app')
@section('title', 'Supplier Product')
@section('content')

    @push('css')
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

            .example-table tr:nth-child(2n+1) {
                background-color: #ddd;
            }

            .example-table tr:nth-child(2n+0) {
                background-color: #eee;
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">

                <div class="col-md-12">
                    <form class="form-horizontal">
                        <div class="box-body">
                            @include('supplier.layout.header')
                            <div>
                                <div class="row">

                                    <div class="col-md-1" onclick="openNav()" style="white-space: nowrap">
                                        <i class="fa fa-fw fa-bars text-color"></i>
                                        Product
                                    </div>

                                </div>

                                @include('supplier.layout.sidebar')

                                <table class="table table-striped table-responsive example-table" style="margin-top: 10px">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Barcode</th>
                                            <th>SKU</th>
                                            <th>Product Name</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Sell</th>
                                            <th>Available</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $value)
                                            @php
                                                $variantName = null;
                                            @endphp
                                            @if (isset($value->productVariations->variantValues))
                                                @php
                                                    $variantName = collect($value->productVariations->variantValues)
                                                        ->pluck('variantValueName.variation_value')
                                                        ->implode('-');
                                                @endphp
                                            @endif
                                            <tr>
                                                <td>{{ serialNumber($products, $loop) }}</td>
                                                <td>{{ $value->product_barcode }}</td>
                                                <td>{{ $value->product_sku }}</td>
                                                <td>{{ $value->product->name ?? '' }} @if (isset($variantName))
                                                        -{{ $variantName }}
                                                    @endif
                                                </td>
                                                <td>{{ collect($products->items())->where('product_id', $value->product_id)->count() }}
                                                </td>
                                                <td>{{ $value->total_quantity }} pcs</td>
                                                <td>{{ $value->total_sale }} pcs</td>
                                                <td>
                                                    @php
                                                        $available = $value->total_quantity - $value->total_sale;
                                                    @endphp
                                                    @if ($available > 5)
                                                        {{ $available }} pcs
                                                    @else
                                                        <span style="color:red">{{ $available }} pcs </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="text-center">
                                                <td colspan="9">
                                                    <h4 class="font-weight-bold">No product available</h4>
                                                </td>
                                            </tr>
                                        @endforelse
                                        <br>
                                        <tr>
                                            <td colspan="4" style="text-align: end">Total =</td>
                                            <td>{{ $total_items }}</td>
                                            <td>{{ $total_quantity }}</td>
                                            <td>{{ $sell_total }}</td>
                                            <td>{{ $available_total }}</td>
                                            <td></td>
                                        </tr>
                                </table>
                                {{ $products->withQueryString()->links() }}
                            </div>
                        </div>
                        <div class="text-center ">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">View Supplier</button>
                                </div>

                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Home</button>
                                </div>


                            </div>


                        </div>
                </div>

                </form>
            </div>
        </div>



    </div>
    </div>


@endsection
@push('js')
    <script>
        function openNav() {
            document.getElementById("mySidepanel").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidepanel").style.width = "0";
        }
    </script>
@endpush
