@extends('layouts.app')
@section('title', 'View Cost')
@section('content')
    @push('css')
        <style>
            sub {
                font-size: smaller;
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

            :-moz-placeholder {
                /* Firefox 18- */
                text-align: center;
            }

            ::-moz-placeholder {
                /* Firefox 19+ */
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

            h2 {
                text-align: center;
            }

            .b_confirm {
                background-color: white;
                color: black;
                border: 0px solid #555555;
            }

            .b_confirm:hover {
                background-color: #29b473;
                color: white;
                border: 4px solid #29b473;
            }

            .image img {
                width: 102px;
                border-radius: 50px;
            }

            .modal-radious {
                border: 0px solid #ededed;
                border-radius: 25px;
            }

            .custom-modal-header {
                background-image: linear-gradient(to right, #343132, #710101);
                border-top-right-radius: 20px;
                border-top-left-radius: 20px;
            }

            .custom-modal-footer {
                background-color: rgb(255, 226, 201);
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
            }

            .tablet {
                border: 2px solid #0a0606;
                border-radius: 8px;
                background-color: black;
                color: white;
            }

            .custom-circle {
                font-size: 50px;
            }

        </style>
    @endpush
    <div style="margin-top: 9%"></div>
    <x-cost.cost-view :cost="$cost"></x-cost.cost-view>
@endsection















