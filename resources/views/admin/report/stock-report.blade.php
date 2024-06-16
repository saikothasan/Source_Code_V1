@extends('layouts.app')
@section('title', 'Stock Report')
@section('content')
    <link rel="stylesheet" href="{{asset('/assets/css/vue-tagsinput.css')}}">
    <style>
        .header {
            color: rgb(2, 2, 2);
            padding-top:20px;
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .box-header {
            border: 1px solid #00c0ef;
            border-radius: 17px;
        }


        td {
            border: 1px solid black;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #000000e0;
            color: white;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }
        hr {
            margin-top: 1px;
            margin-bottom: 1px;
            border: 0;
            border-top: 2px solid #ddd5d5;;
        }
        .color-gray {
            color: gray;
        }
        .groupedInput {
            border: 1px solid #e1cdcd;
            border-radius: 7px;
            /*border-radius: 10px;*/
        }

        .spacer {
            margin-top: 20px;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(0 0 0);
        }
        .filter {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }


    </style>
    <div class="content-wrapper" id="app">
        <stock-report :resource="{{$resource}}"></stock-report>
    </div>

@endsection

@push('js')
<x-routes></x-routes>
    <script src="{{mix('js/app.js')}}"></script>
@endpush
