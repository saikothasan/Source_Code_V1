@extends('layouts.app')
@section('title', 'Recevied Product')

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
        <x-transfer.received-view :received="$receivedProduct"></x-transfer.received-view>
    </div>
@endsection
