@extends('layouts.app')
@section('title', 'View Banks ')
@section('content')
    <style>
        .top-radious {
            border-top-left-radius: 11px;
            border-top-right-radius: 11px;
        }

        .small-box {
            box-shadow: 2px 3px 10px rgb(0 0 0 / 30%);
        }

        .small-box .inner {
            padding: 10px;
            border: none !important;
        }

        .bottom-radious {
            border-bottom-left-radius: 11px;
            border-bottom-right-radius: 11px;
        }

        .font {
            font-family: RobotoLight;
        }

        .btn {
            width: 100%;
        }

        .font-width {
            font-weight: 700;
        }

        .product {
            background-color: #babbbb !important;
            font-size: 15px;
            font-weight: 600;
            color: black;
        }

        .product a {
            color: white;
        }

        .product-inner {
            background-color: rgb(255, 255, 255) !important;
            color: rgb(35, 31, 32);
            border-radius: 5px;
        }

        .small-box>.inner {
            padding: 10px;
            border: 1px solid rgb(38 169 224);
        }

        .header h4 {
            background: black;
            padding: 9px;
            max-width: 217px;
            text-align: center;
            margin: auto;
            color: white;
            border-radius: 9px;
            font-size: 36px;
            font-weight: 700;
            padding-top: 9px;
        }

        .amount {
            font-size: 23px;
            padding: 13px;
        }

        .btn-gray {
            width: 125px !important;
            background: #ddd9d9;
            color: #5a5757;
        }
    </style>

    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row" style="margin-top: 5px">
                    <div class="col-lg-3 col-md-3 col-xs-12"></div>
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="box-tools ">

                            @if (!isSupplier())
                                <a href="{{ route('banks.create') }}"
                                    style="border-radius: 12px;border-color: green;color: black" class="btn btn-sm"
                                    onmouseover="this.style='border-radius: 12px;border-color: green; background-color:green; color:white'"
                                    onmouseout="this.style='border-radius: 12px;border-color: green;color: black'">
                                    <i class="fa fa-plus"></i> {{translate('New')}} {{translate('Bank')}}</a>
                            @endif
                        </div>
                        <br>

                        <div class="row">
                            @foreach ($banks as $key => $value)
                                @if ($value->is_main_bank == 1)
                                    <center>
                                        {{-- <h2><strong>Main Bank Account</strong></h2> --}}
                                        <div class="col-md-6 ">
                                            <div class="background-box">


                                                <div class="small-box">
                                                    <div class="header">
                                                        <h4>
                                                            @if ($value->is_main_bank && auth()->user()->branch_id == $value->branch_id)
                                                                Admin
                                                            @else
                                                                {{ Str::limit($value->user->name, 8) }}
                                                            @endif


                                                        </h4>
                                                    </div>
                                                    <div class="inner text-center product-inner">
                                                        <div class="font">
                                                            <strong>{{ $value->name }}</strong>
                                                        </div>
                                                        <div class="font">
                                                            <strong>{{ $value->account_no }}</strong>
                                                        </div>

                                                        <div class="amount"><strong> {{get_settings('currency_name')}} {{ $value->amount }}
                                                                {{get_settings('currency_symbol')}}</strong></div>

                                                        <a href="{{ route('single-bank-transaction', $value->id) }}">
                                                            <button class="btn btn-gray">{{translate('Transaction')}}</button>
                                                        </a>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>


                                    </center>
                                @endif

                                @if ($value->is_main_bank == 0)
                                    <div class="col-md-6">
                                        <div class="background-box">


                                            <div class="small-box">
                                                <div class="header">
                                                    <h4>{{ Str::limit($value->user->name, 8) }}
                                                </div>
                                                <div class="inner text-center product-inner">
                                                    <div class="font"> {{ $value->name }}</div>
                                                    <div class="font">{{ $value->account_no }}</div>

                                                    <div class="amount"><strong> {{get_settings('currency_name')}} {{ $value->amount }} {{get_settings('currency_symbol')}}</strong>
                                                    </div>

                                                    <a href="{{ route('single-bank-transaction', $value->id) }}">
                                                        <button class="btn btn-gray">{{translate('Transaction')}}</button>
                                                    </a>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="row text-center form-group mt-5">
                            @if (!isSupplier())
                                <div class="col-md-4">
                                    <a href="{{ route('bank-transfer.create') }}">
                                        <button type="button" class="btn btn-warning">{{translate('Transfer')}} {{translate('Amount')}}</button>
                                    </a>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <a href="{{ route('bank-transfer.index') }}">
                                    <button type="button" class="btn btn-primary">{{translate('View')}} {{translate('Transaction')}}</button>
                                </a>

                            </div>

                            @if (!isSupplier())
                                <div class="col-md-4">
                                    <a href="{{ route('banks.create') }}">
                                        <button type="button" class="btn  btn-success"> {{translate('Add')}} {{translate('Bank')}}</button>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-xs-12"></div>
                </div>

            </div>
    </div>


    </section>
    </div>
    </div>
@endsection
