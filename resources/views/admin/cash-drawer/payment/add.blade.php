@extends('layouts.app')
@section('title', 'Payment')
@section('content')
    <div class="content-wrapper" id="app">
        <payment-component :payment-resource="{{$payment_resource}}"></payment-component>
    </div>
@endsection
@section('footerSection')
    @push('js')
        <script>
            window.Laravel = {!! json_encode([
                        'csrfToken' => csrf_token(),
                        'baseUrl' => url('/'),
                        'routes' => collect(\Route::getRoutes())->mapWithKeys(function ($route) { return [$route->getName() => $route->uri()]; })
                    ]) !!};
        </script>
        <script src="{{mix('js/app.js')}}"></script>
    @endpush
@endsection
