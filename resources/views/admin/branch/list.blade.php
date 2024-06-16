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
            font-family: RobotoLight, serif;
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
                    <div class="box-tools text-center">
                        <a href="{{ route('branch.create') }}" class="btn btn-sm bg-green">
                            <i class="fa fa-plus"></i>
                            {{translate('New')}} {{translate('Branch')}}
                        </a>
                    </div>
                    <br>
                </div>
                <div class="row">
                    @foreach ($branches as $key => $value)
                    <div class="col-md-3 col-sm-6 small-box">
                        <a class="small-box-footer top-radious" href=""  style="border: 1px solid rgb(31,97,141);background: white;  color: rgb(31,97,141);">
                            <strong>
                            @if ($value->is_main_branch)
                                <i style="color: #ffc800; font-size: 17px;" class="fa fa-star"></i>
                            @endif
                            {{ $value->name }}
                        </strong></a>
                        <div class="inner text-center product-inner">
                            {{-- <p class="font">Available Product - <Span class="font-width"> {{$value->available}} pcs</Span>
                            </p>
                            <p class="font">Today Expenses - <Span class="font-width"> {{number_format($value->today_expenses)}} {{get_settings('currency_symbol')}}</Span>
                            </p>
                            <p class="font">Today Sold - <Span class="font-width">{{number_format($value->today_sales)}} {{get_settings('currency_symbol')}}</Span>
                            </p>
                            <p class="font">Status - <Span class="font-width">
                            @if ($value->status)
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-danger">Inactive</span>
                                    @endif </Span></p> --}}

                                    <strong>{{translate('Available')}} {{translate('Product')}}</strong>
                                    <p>{{ $value->available }} {{translate('pcs')}}</p>
                                    <strong>{{translate('Today')}} {{translate('Expenses')}} </strong>
                                    <p>{{ number_format($value->today_expenses) }} {{get_settings('currency_symbol')}}</p>
                                    <strong>{{translate('Today')}} {{translate('Sold')}} </strong>
                                    <p> {{ number_format($value->today_sales) }} {{get_settings('currency_symbol')}}</p>
                                    <strong>{{translate('Status')}}</strong>
                                    <p>{{ $value->status? translate('Active'): translate('Inactive')}}</p>
                        </div>
                         {{--                                    href="{{route('branch.edit',$value->id)}}" --}}
                         <a href="{{ route('branch.sale', ['branch' => $value->id, 'type' => 'sale']) }}"
                            class="small-box-footer bottom-radious font product">{{translate('More')}} {{translate('info')}}</a>
                    </div>

                    @endforeach
                </div>
            </div>
            <div style="width: 30%; margin: auto;">
                <div class="row text-center form-group mt-5">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <a href="{{ route('suppliers.index') }}">
                            <button type="submit" class="btn btn-success"> {{translate('View')}} {{translate('Suppliers')}}
                            </button>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
                </div>
            </div>

        </section>
    </div>

@endsection
