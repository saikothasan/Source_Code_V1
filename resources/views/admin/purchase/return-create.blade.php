@extends('layouts.app')
@section('title', 'Purchase Return')

@section('content')
    @push('css')
        <style>
            .table-size {
                width: 63%;
                margin: auto;
            }
        </style>
    @endpush
    <div class="content-wrapper" id="app">
        <purchase-return :purchase="{{ json_encode($purchase) }}"></purchase-return>
    </div>
@endsection
@push('js')
<x-routes></x-routes>
    <script src="{{mix('js/app.js')}}"></script>
@endpush
