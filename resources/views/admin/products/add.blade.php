@extends('layouts.app')
@section('title', 'Add New Product')
@section('content')
    @push('css')
        <link rel="stylesheet" href="{{asset('/assets/css/vue-tagsinput.css')}}">
        <style>
            .div-center {
                display: flex;
                justify-content: center;
            }

            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
            @media only screen and (max-width: 768px) {
              .custom-box {
                  width: 100%;
              }
            }
        </style>
    @endpush
    <div class="content-wrapper" id="product">
        <add-product :categories="{{ $categories }}"
                     :suppliers="{{ $suppliers }}"
                     :brands="{{ $brands }}"
                     :variations="{{ $variations }}"
                     :auth-supplier="{{ $auth_supplier }}"
        ></add-product>

    </div>
@endsection

@push('js')
    <x-routes></x-routes>
    <script src="{{mix('js/product.js')}}"></script>
@endpush
