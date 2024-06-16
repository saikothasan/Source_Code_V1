@extends('layouts.app')
@section('title', 'View Branch')
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
            background-color: rgb(31, 97, 141) !important;
            color: #ffff;
        }

        .product-inner {
            background-color: rgb(255, 255, 255) !important;
            color: rgb(35, 31, 32);
        }

        .small-box>.inner {
            padding: 10px;
            border: 1px solid rgb(31, 97, 141);
        }
    </style>

    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row" style="margin-top: 5px">
                    <div class="col-lg-4 col-xs-6"></div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box">
                            <a href="#" class="small-box-footer top-radious"
                                style="border: 1px solid rgb(31,97,141);background: white;    color: rgb(31,97,141);">BRANCH
                                NAME</a>
                            <div class="inner text-center product-inner">
                                <p class="font">Available Product - <Span class="font-width"> 8062 pcs</Span></p>
                                <p class="font">Today Expenses - <Span class="font-width"> 585 {{get_settings('currency_symbol')}}</Span></p>
                                <p class="font">Today Sold - <Span class="font-width">20,000 {{get_settings('currency_symbol')}}</Span></p>
                                <p class="font">Status - <Span class="font-width"> Active-</Span></p>
                            </div>
                            <a href="{{ route('purchases.index') }}"
                                class="small-box-footer bottom-radious font product">More info</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6"></div>
                </div>
                <div class="row" style="margin-top: 5px">
                    <div class="col-lg-4 col-xs-6"></div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box">
                            <a href="#" class="small-box-footer top-radious "
                                style="border: 1px solid rgb(31,97,141);background: white;color: rgb(31,97,141);">BRANCH
                                NAME</a>
                            <div class="inner text-center product-inner">
                                <p class="font">Available Product - <Span class="font-width"> 8062 pcs</Span></p>
                                <p class="font">Today Expenses - <Span class="font-width"> 585 {{get_settings('currency_symbol')}}</Span></p>
                                <p class="font">Today Sold - <Span class="font-width">20,000 {{get_settings('currency_symbol')}}</Span></p>
                                <p class="font">Status - <Span class="font-width"> Active-</Span></p>
                            </div>
                            <a href="{{ route('purchases.index') }}"
                                class="small-box-footer bottom-radious font product">More info</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6"></div>
                </div>
            </div>
    </div>
    <div class="custom-center text-center row">
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Report</button>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-success">View Suppliers</button>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Home</button>
        </div>
    </div>
    </section>
    </div>
    </div>
@endsection
