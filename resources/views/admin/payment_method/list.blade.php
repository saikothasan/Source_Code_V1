@extends('layouts.app')
@section('title', 'Payment Method List')
@section('content')
    <style>
        .dashboard .container {
            width: 55%;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .custom-btn {
            position: relative;
        }

        .custom-add {
            position: absolute;
            border-radius: 5px;
            right: 35px;
            z-index: 9;
            border: none;
            top: 2px;
            height: 30px;
            cursor: pointer;
            color: #423030;
            background-color: transparent;
            transform: translateX(2px);
        }

        .font {
            font-family: 'Roboto Light', serif;
        }

        .custom-home {
            padding: 8px 59px;
            font-size: 18px;
            line-height: 1.3333333;
        }


        .card {
            margin-right: auto;
            margin-left: auto;
            width: 210px;
            box-shadow: 0px 0px 20px 1px rgb(129 124 124 / 30%);
            height: 170px;
            border-radius: 13px;
            backdrop-filter: blur(14px);
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px;
            text-align: center;
        }

        .card img {
            width: 50%;
            text-align: center;
        }

        .total-active {
            background-color: green;
        }

        .today-active {
            background-color: rgb(33, 153, 117);
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3><strong>{{ translate('Payment') }} {{ translate('Method') }}</strong></h3>
                        </div>
                    </div>
                    <div class="col-md-12 row" style="margin-top: 5px">
                        <form method="get" action="{{ route('payment-method.index') }}" class="col-md-6 bg-none">
                            <div class="text-center form-group">
                                <label>
                                    <input hidden name="filter" value="today" />
                                </label>
                                <button class="btn {{ request()->get('filter') === 'today' ? 'today-active' : '' }}"
                                    style="border-radius: 12px;border-color: rgb(56, 53, 53);width: 60%;height: 35px;color: black"
                                    onmouseover="this.style='border-radius: 12px;width: 60%;height: 35px;background-color:rgb(255,64,0) ;color:white'"
                                    onmouseout="this.style='border-radius: 12px;border-color: orange;width: 60%;height: 35px;color: black'"
                                    type="submit">
                                    {{ translate('Today') }}
                                </button>
                            </div>
                        </form>
                        <div class=" col-md-6 text-center">
                            <div class="form-group">
                                <a href="{{ request()->url() }}">
                                    <button class="btn {{ request()->get('filter') != 'today' ? 'total-active' : '' }}"
                                        style="border-radius: 12px;border-color: rgb(56, 53, 53);width: 60%;height: 35px;color: black"
                                        onmouseover="this.style='border-radius: 12px;width: 60%;height: 35px;background-color:green ;color:white'"
                                        onmouseout="this.style='border-radius: 12px;border-color: rgb(255,64,0);width: 60%;height: 35px;color: black'">{{ translate('Total') }}</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row text-center" style="padding-top: 25px">
                    @foreach ($paymentMethods as $paymentMethod)
                        <div class="col-lg-3 col-xs-6 col-md-4" style="padding-bottom: 25px">
                            <div class="card text-center">
                                <div class="row">
                                    <h4> <strong>{{ $paymentMethod->name }}</strong> <a
                                            href="{{ route('payment-method.edit', $paymentMethod->id) }}"><i
                                                class="fa fa-edit"></i></a></h4>

                                </div>

                                @if ($paymentMethod->photo)
                                    <a
                                        href="{{ $paymentMethod->total_balance > 0 ? route('payment-method.show', $paymentMethod->id) : route('payment-method.index') }}">
                                        <img src="{{ asset($paymentMethod->photo) }}" style="height:50%"
                                            onerror="this.onerror=null;this.src='{{ asset('images/sales/money.png') }}';"
                                            alt="Card Back">
                                    </a>
                                @else
                                    <a
                                        href="{{ $paymentMethod->total_balance > 0 ? route('payment-method.show', $paymentMethod->id) : route('payment-method.index') }}">
                                        <img src="{{ asset('images/sales/08.png') }}" alt="Card Back">
                                    </a>
                                @endif
                                <h4> {{ floatFormat($paymentMethod->total_balance) }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-md-12 row" style="margin-top: 5px">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('transfer-money.create') }}">
                                <button class="btn" style="background-color: rgb(0,67,0);color: white;">
                                    {{ translate('Amount') }} {{ translate('Transfer') }}
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <br />

                <div class="row text-center" style="background-color:rgb(235,235,235);border-radius: 13px;">
                    <div class="col-md-2"></div>
                    <form method="POST" action="{{ route('payment-method.store') }}" class="col-md-8"
                        enctype="multipart/form-data" style="margin-top: 5px">
                        @csrf
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-md-6">
                                <label>{{ translate('Method') }} {{ translate('Name') }}</label>
                                <input name="name" placeholder="Name" class="form-control" required="" type="text"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6">
                                <label>Icon</label>
                                <input type="file" class="form-control" placeholder="Upload/url" name="photo">
                            </div>
                        </div>
                        <div class="row" style="padding: 20px;">
                            <button class="btn btn-info" style="border-radius: 12px;width: 20%;color: white">
                                {{ translate('ADD') }}
                            </button>
                        </div>
                    </form>
                    <div class="col-md-2"></div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
@push('js')
    <script>
        // profile picture change
        function readPicture(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#supplier_photo')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
