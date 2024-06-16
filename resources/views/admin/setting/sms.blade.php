@extends('layouts.app')
@section('title', 'SMS Setting')
@section('content')

@section('title', translate('SMS Setting'))

@push('css_or_js')
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content ">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">{{ translate('nexmo_sms') }}</h5>
                    </div>
                    <div class="card-body text-{{ Session::get('direction') === 'rtl' ? 'right' : 'left' }}">
                        <span
                            class="badge text-wrap badge-soft-info mb-3">{{ translate('NB_:_#OTP#_will_be_replace_with_otp') }}</span>
                        @php($config = get_settings('nexmo_sms'))
                        <form action="{{ env('APP_MODE') != 'demo' ? route('sms.update', ['nexmo_sms']) : 'javascript:' }}"
                            style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};" method="post">
                            @csrf

                            <label class="mb-3 d-block title-color">{{ translate('nexmo_sms') }}</label>


                            <div class="d-flex gap-10 align-items-center mb-2">
                                <input type="radio" name="status" value="1"
                                    {{ isset($config) && $config['status'] == 1 ? 'checked' : '' }}>
                                <label class="title-color mb-0">{{ translate('active') }}</label>

                            </div>
                            <div class="d-flex gap-10 align-items-center mb-4">
                                <input type="radio" name="status" value="0"
                                    {{ isset($config) && $config['status'] == 0 ? 'checked' : '' }}>
                                <label class="title-color mb-0">{{ translate('inactive') }} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-capitalize" class="title-color">{{ translate('api_key') }}</label>
                                <input type="text" class="form-control" name="api_key"
                                    value="{{ env('APP_MODE') != 'demo' ? $config['api_key'] ?? '' : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{ translate('api_secret') }}</label>
                                <input type="text" class="form-control" name="api_secret"
                                    value="{{ env('APP_MODE') != 'demo' ? $config['api_secret'] ?? '' : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{ translate('from') }}</label>
                                <input type="text" class="form-control" name="from"
                                    value="{{ env('APP_MODE') != 'demo' ? $config['from'] ?? '' : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="title-color">{{ translate('otp_template') }}</label>
                                <input type="text" class="form-control" name="otp_template"
                                    value="{{ env('APP_MODE') != 'demo' ? $config['otp_template'] ?? '' : '' }}">
                            </div>
                            <div class="mt-3 d-flex flex-wrap justify-content-end gap-10">
                                <button type="{{ env('APP_MODE') != 'demo' ? 'submit' : 'button' }}"
                                    onclick="{{ env('APP_MODE') != 'demo' ? '' : 'call_demo()' }}"
                                    class="btn btn-primary px-4">{{ translate('save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@push('js')
@endpush
