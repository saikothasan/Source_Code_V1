@extends('layouts.app')
@section('title', 'Transfer Product')
@section('content')
    @push('css')
        <style>
            .form-control,
            .selection {
                border-radius: 7px;
                box-shadow: none;
                border-color: #06cdffd6 !important;
                height: 35px;
                color: #000000;
            }
        </style>
    @endpush
    <div class="content-wrapper" id="app">
        <create-transfer :user="{{ $user }}" :invoice="{{ $invoice }}" :date="{{ $date }}"
            :send-branch="{{ $send_branch }}"></create-transfer>
    </div>

@endsection

@push('js')
    <x-routes></x-routes>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
