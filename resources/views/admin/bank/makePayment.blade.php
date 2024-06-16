@extends('layouts.app')
@section('title', 'Make Payment')
@section('content')
    @push('css')
        <style>
            .supplier_content {
                text-align: center;
            }

            .form-control {
                border-radius: 7px;
                box-shadow: none;
                border-color: #06cdffd6 !important;
                height: 50px;
            }


            ::-webkit-input-placeholder {
                text-align: center;
            }

            :-moz-placeholder { /* Firefox 18- */
                text-align: center;
            }

            ::-moz-placeholder { /* Firefox 19+ */
                text-align: center;
            }

            :-ms-input-placeholder {
                text-align: center;
            }

            .image img {
                width: 102px;
                border-radius: 50px;
            }

            .image input {
                margin-left: 37%;
                margin-top: 23px;
            }


        </style>
    @endpush
    <div class="content-wrapper" id="app">
        <bank-payment :resource="{{json_encode($resource)}}"></bank-payment>
    </div>
@endsection
@push('js')
   <x-routes></x-routes>
    <script src="{{mix('js/app.js')}}"></script>
@endpush
