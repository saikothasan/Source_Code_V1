@extends('layouts.app')
@section('title', 'Cash Drawer')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h2 class="text-uppercase"><strong>{{translate('Cash')}} {{translate('Drawer')}}</strong></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h1><strong class="green-color" style="font-size: -webkit-xxx-large;">{{get_settings('currency_name')}}
                                    {{ $cashDrawer->amount ?? 0 }}</strong></h1>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row text-center">
                    <div class="col-md-12 text-center row">
                        <div class="col-md-12  text-center row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 row">
                                <div class="col-md-4">
                                    <div class="form-group" style="min-width: 150px;">
                                        <a href="{{ route('cash-in.create') }}" >
                                            <button class="form-control text-uppercase" style="color: #000"
                                                onmouseover="this.style='background-color:blue;color:white'"
                                                onmouseleave="this.style='color: #000'" > {{translate('Cash')}} {{translate('In')}}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="min-width: 90px;">
                                        <a href="{{ route('transfer.create') }}">
                                            <button class="form-control text-uppercase" style="color: #000"
                                                onmouseover="this.style='background-color:blue;color:white'"
                                                onmouseleave="this.style='color: #000'"> {{translate('Transfer')}}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="min-width: 90px;">
                                        <a href="{{ route('payment.create') }}">
                                            <button class="form-control black-color text-uppercase" style="color: #000"
                                                onmouseover="this.style='background-color:blue;color:white '"
                                                onmouseleave="this.style='color: #000'">{{translate('Payment')}}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-12 text-center row">
                        <div class="col-md-12  text-center row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 row">
                                <div class="col-md-8">
                                    <div class="form-group" style="min-width: 190px;">
                                        <a href="{{ route('cash-drawer.create') }}">
                                            <button class="form-control text-uppercase" style="background-color:#000;color: white">
                                                {{translate('View')}}
                                                {{translate('Cash')}} {{translate('History')}}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" style="min-width: 90px;">
                                        <a href="{{ route('costs.create') }}">
                                            <button class="form-control black-color text-uppercase" style="color: #000">{{translate('Cost')}}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
