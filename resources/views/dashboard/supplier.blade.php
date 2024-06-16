@extends('layouts.app')
@section('title', 'Supplier Dashboard')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/morris/morris.css') }}">
    <style>
        .form {
            background: #ffffff;
            margin: 10px;
            padding: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row form">
                <form action="{{ route('home') }}" method="get">
                    <div class="from-group col-md-4">
                        <label for="">From</label>
                        <input type="date" value="{{ request()->get('from-date') }}" name="from-date" class="form-control"
                            placeholder="from_date">
                    </div>
                    <div class="from-group col-md-4">
                        <label for="">To</label>
                        <input type="date" value="{{ request()->get('to-date') }}" name="to-date" class="form-control"
                            placeholder="to_date">
                    </div>
                    <div class="col-md-2">
                        <label for=""></label>
                        <button type="submit"  class="btn btn-block btn-success btn-flat" style="border-radius: 12px; margin-top:3px;"> {{ translate('Apply') }}</button>
                    </div>
                    <div class="col-md-2">
                        <label for=""></label>
                        <a  href="{{ request()->url() }}"  class="btn btn-block btn-primary btn-flat" style="border-radius: 12px; margin-top:3px;"> {{ translate('Clear') }}</a>
                    </div>
                </form>
            </div>
            <div class="row">
                @foreach ($supplier_sliders as $slider)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa"> {{ get_settings('currency_symbol') }}</i></span>

                            <div class="info-box-content">
                                <span class="info-box-text text-bold">{{ $slider['title'] }}
                                </span>
                                <span class="info-box-number text-large">{{ $slider['total'] }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                @endforeach
            </div>
        </section>
    </div>

@endsection
@push('js')
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="{{ asset('assets/plugins/morris/morris.js') }}"></script>
@endpush
