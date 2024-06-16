@extends('layouts.app')
@section('title', 'Purchase details')

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
        <x-purchases.purchases-view :purchase="$purchase"></x-purchases.purchases-view>
    </div>
@endsection
