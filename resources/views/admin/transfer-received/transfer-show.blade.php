@extends('layouts.app')
@section('title', 'Transfer details')

@section('content')
    @push('css')
        <style>
            .table-size {
                width: 63%;
                margin: auto;
            }
            @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <x-transfer.transfer-view :transfer="$transferProduct"></x-transfer.transfer-view>
    </div>
@endsection
