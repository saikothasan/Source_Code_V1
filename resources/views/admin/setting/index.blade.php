@extends('layouts.app')
@section('title', 'Settings')
@section('content')
    @push('css')
        <style>
            .div-center {
                display: flex;
                justify-content: center;
            }

            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content ">
            <form method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="custom-box " style="margin-top: 20px">
                    <div class="box-body">
                        <h4 class="text-center  text-bold" style="padding-bottom: 15px;">{{translate('Settings')}}</h4>
                        <div class="form-group image text-center">
                            @if ($settings['site_logo'])
                                <img src="{{ asset($settings['site_logo']) }}" alt="" id="logo">
                            @else
                                <img src="{{ asset('images/blank.jpg') }}" alt="" id="logo">
                            @endif

                            <div class="col-sm-12">
                                <label for="">{{translate('Logo')}}</label>
                                <input type="file" name="site_logo" onchange="readPicture(this)">
                            </div>
                        </div>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="product_sku">{{translate('Site')}} {{translate('Name')}}</label>
                                        <input type="text" class="form-control" name="site_name" id="product_sku"
                                            value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                                            placeholder="Enter site name">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="product_code">{{translate('Phone')}} {{translate('Number')}}</label>
                                        <input type="number" class="form-control"
                                            value="{{ old('phone_number', $settings['phone_number'] ?? '') }}"
                                            name="phone_number" placeholder="Enter Phone Number">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="product_sku">{{translate('Email')}}</label>
                                        <input type="email" class="form-control" maxlength="10" name="email"
                                            value="{{ old('email', $settings['email'] ?? '') }}" placeholder="Enter Email">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label for="product_code">{{translate('Verify')}} {{translate('Email')}}</label>
                                        <input type="email" class="form-control"
                                            value="{{ old('verify_email', $settings['verify_email'] ?? '') }}"
                                            name="verify_email" placeholder="Enter Verify Email">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-box " style="margin-top: 20px">
                    <div class="box-body">
                        <h4 class="text-center  text-bold" style="padding-bottom: 15px;">{{translate('Pos')}} {{translate('Setting')}}</h4>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>{{translate('Default')}} {{translate('Vat')}} {{translate('Percentage')}}</label>
                                        <input type="number" step="0.1" class="form-control" name="vat_percentage"
                                            value="{{ old('vat_percentage', $settings['vat_percentage'] ?? '') }}"
                                            placeholder="Enter Sell Vat">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="input-group" style="display: flex; justify-content: space-around;">
                                        <label>{{translate('Exchange')}} {{translate('Total')}}</label>
                                        <label>{{translate('Exchange')}} {{translate('In')}}</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm" name="exchange_total"
                                            value="{{ old('exchange_total', $settings['exchange_total'] ?? '') }}" />
                                        <span class="input-group-btn" style="width:0px;"></span>
                                        <input type="text" class="form-control input-sm" name="exchange_in"
                                            value="{{ old('exchange_in', $settings['exchange_in'] ?? '') }}" />
                                        <span class="input-group-addon pointer">
                                            {{translate('Day')}}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-6">
                                    <div class="input-group" style="display: flex; justify-content: space-around;">
                                        <label for="product_sku">{{translate('Return')}} {{translate('Total')}}</label>
                                        <label for="product_sku">{{translate('Return')}} {{translate('In')}}</label>
                                    </div>
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm" name="return_total"
                                            value="{{ old('return_total', $settings['return_total'] ?? '') }}" />
                                        <span class="input-group-btn" style="width:0px;"></span>
                                        <input type="text" class="form-control input-sm" name="return_in"
                                            value="{{ old('return_total', $settings['return_in'] ?? '') }}" />
                                        <span class="input-group-addon pointer">
                                            {{translate('Day')}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row div-center">
                            <div class="col-md-12">
                                <div class="col-md-12">

                                    <label for="product_code">{{translate('Sale')}} {{translate('Footer')}}</label>
                                    <textarea id="sale_footer" name="sale_footer" class="form-control" name="sale_footer"
                                        placeholder="Enter Verify Email"> {{ old('sale_footer', $settings['sale_footer'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row div-center">
                            <div class="col-md-12 text-center">
                                <div class="form-group image ">
                                    @if ($settings['print_logo'])
                                        <img src="{{ asset($settings['print_logo']) }}" style="height:50px;"
                                            alt="" id="logo">
                                    @else
                                        <img src="{{ asset('images/blank.jpg') }}" alt="" id="logo">
                                    @endif

                                    <div class="col-sm-12 ">
                                        <label for="">{{translate('Print')}} {{translate('Logo')}}</label>
                                        <input type="file" name="print_logo" onchange="readPicture(this)">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="custom-box " style="margin-top: 20px">
                    <div class="box-body">
                        <h4 class="text-center  text-bold" style="padding-bottom: 15px;">Currency Setting</h4>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>{{translate('Currency')}} {{translate('Name')}} </label>
                                        <input type="text" step="0.1" class="form-control" name="currency_name"
                                            value="{{ old('currency_name', $settings['currency_name'] ?? '') }}"
                                            placeholder="currency ">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>{{translate('Currency')}} {{translate('Symbol')}}</label>
                                        <input type="text" step="0.1" class="form-control" name="currency_symbol"
                                            value="{{ old('currency_symbol', $settings['currency_symbol'] ?? '') }}"
                                            placeholder="currency ">
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="custom-box " style="margin-top: 20px">
                    <div class="box-body">
                        <h4 class="text-center  text-bold" style="padding-bottom: 15px;">Delivery System</h4>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>{{translate('Inside Dhaka Additional Charge')}}</label>
                                        <input type="number" step="0.1" class="form-control"
                                            name="inside_dhaka_charge"
                                            value="{{ old('inside_dhaka_charge', $settings['inside_dhaka_charge'] ?? '') }}"
                                            placeholder="Enter Amount">
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>{{translate('Outside Dhaka Additional Charge')}}</label>
                                        <input type="number" step="0.1" class="form-control"
                                            name="outside_dhaka_charge"
                                            value="{{ old('outside_dhaka_charge', $settings['outside_dhaka_charge'] ?? '') }}"
                                            placeholder="Enter Amount">
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


                <div style="margin-top: 20px;text-align: center;">
                    <div>
                        <button type="submit" class="btn btn-primary">{{translate('Submit')}}</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('js')
    <script>
        // profile picture change
        function readPicture(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#logo')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
