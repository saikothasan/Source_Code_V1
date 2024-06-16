@extends('layouts.app')
@section('title', 'New Purchase')
@section('content')
    @push('css')
        <style>
            .form-control, .selection {
                border-radius: 7px;
                box-shadow: none;
                border-color: #06cdffd6 !important;
                height: 35px;
                color: #bbbdbf;
            }
        </style>
    @endpush
    <div class="content-wrapper" id="app">

        <add-purchase
            :user="{{ $user }}"
            :invoice="{{ $invoice }}"
            :date="{{ $date }}"
            :receive-user="{{ $receive_user }}"
        ></add-purchase>
    </div>

@endsection

@push('js')
<x-routes></x-routes>
    <script src="{{mix('js/app.js')}}"></script>
@endpush
