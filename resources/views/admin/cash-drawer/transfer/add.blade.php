@extends('layouts.app')
@section('title', 'Transfer')
@section('content')
    <div class="content-wrapper" id="app">
        <transfer-component :transfer-resource="{{$transfer_resource}}"></transfer-component>
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
