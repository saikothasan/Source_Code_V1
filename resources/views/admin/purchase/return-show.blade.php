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
    <div class="content-wrapper">
        <x-purchases.return-purchases-view :purchase="$purchase_return"></x-purchases.return-purchases-view>
    </div>
@endsection
