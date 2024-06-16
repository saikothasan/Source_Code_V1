@extends('layouts.app')
@section('title', 'View Supplier ')
@section('content')
    <style>
        .top-radious {
            border-top-left-radius: 11px;
            border-top-right-radius: 11px;
        }

        .bottom-radious {
            border-bottom-left-radius: 11px;
            border-bottom-right-radius: 11px;
        }

        .font {
            font-family: RobotoLight;
        }

        .font-width {
            font-weight: 700;
        }

        .product {
            background-color: #26A9E0 !important;
            font-size: 15px;
            font-weight: 600;
            color: white;
        }

        .product a {
            color: white;
        }

        .product-inner {
            background-color: rgb(255, 255, 255) !important;
            color: rgb(35, 31, 32);
        }

        .small-box>.inner {
            padding: 10px;
            border: 1px solid rgb(38 169 224);
        }
    </style>

    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">

                <div class="row text-center" style="margin-top: 5px">
                    <div class="col-md-12 ">
                        <div class="box-tools text-center mb-3">

                            <a href="{{ route('suppliers.create') }}"
                                style="width: 100%;border-radius: 12px;border-color: green;color: black ; margin-bottom:2%;"
                                class="btn btn-sm"
                                onmouseover="this.style='width: 100%;border-radius: 12px;border-color: green; background-color:green; color:white; margin-bottom:2%;'"
                                onmouseout="this.style='border-radius: 12px;border-color: green;color: black;width: 100%; margin-bottom:2%;';">
                                <i class="fa fa-plus"></i> {{translate('New')}} {{translate('Supplier')}}</a>
                        </div>
                    </div>
                    <br>
                </div>

                <div class="row">
                    @foreach ($suppliers as $key => $value)
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="small-box">
                                <a href="#" class="small-box-footer top-radious"
                                    style="border:  1px solid rgb(31,97,141);background: white;  color: rgb(31,97,141);">
                                    {{--                                        <h5 class="small-box-footer"> --}}
                                    {{--                                            <strong> --}}
                                    {{--                                                @if ($value->is_main_branch) --}}
                                    {{--                                                    <i style="color: #ffc800; font-size: 17px;" class="fa fa-star"></i> --}}
                                    {{--                                                @endif --}}
                                    {{--                                                {{ $value->name }} --}}
                                    {{--                                            </strong> --}}
                                    {{--                                        </h5> --}}
                                    <h5 class="small-box-footer">
                                        <strong>
                                            @if ($value->is_main_branch)
                                                <i style="color: #ffc800; font-size: 17px;" class="fa fa-star"></i>
                                            @endif
                                            {{ $value->name }}
                                        </strong>
                                    </h5>

                                </a>
                                <div class="inner text-center product-inner">
                                    {{--                                        <div class="row"> --}}
                                    {{--                                            <p class="font"> Product - <Span class="font-width"> {{ $value->supplierPurchaseDetail ? $value->supplierPurchaseDetail->total_quantity : 0 }} pcs</Span> --}}
                                    {{--                                            </p> --}}
                                    {{--                                        </div> --}}
                                    {{--                                        <div class="row">  <p class="font">Payment - <Span class="font-width"> 585 {{get_settings('currency_symbol')}}</Span></p></div> --}}
                                    {{--                                        <div class="row">  <p class="font">Due - <Span class="font-width">20,000 {{get_settings('currency_symbol')}}</Span></p></div> --}}
                                    {{--                                        <div class="row">  <p class="font">Stock - <Span class="font-width"> 20,000 {{get_settings('currency_symbol')}}</Span></p></div> --}}
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <p class="font">{{translate('Payment')}} </p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <p class="font-width">
                                                {{ number_format($value->supplierPurchaseDuePayment->total_due_paid ?? 0) }} {{getsetting('currency_symbol')}}
                                                </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <p class="font">{{translate('Due')}} </p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <p class="font-width">
                                                {{ number_format($value->supplierPurchaseDuePayment->total_due_after_paid ?? 0) }} {{getsetting('currency_symbol')}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <p class="font">Stock </p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <p class="font-width"> {{ number_format($value->stocks_count) }} {{getsetting('currency_symbol')}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="small-box-footer bottom-radious font product">
                                    <a href="{{ route('suppliers.show', $value->id) }}">{{translate('More')}} {{translate('info')}}</a>

                                    {{--                                   <a class="full-right" style="margin-left:20%;" href="{{route('suppliers.edit',$value->id)}}" --}}
                                    {{--                                    ><i class="fa fa-edit"></i></a> --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </section>
    </div>

@endsection
