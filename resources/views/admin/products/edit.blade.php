@extends('layouts.app')
@section('title', 'Product Update')
@section('content')

    @push('css')
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
        <edit-product :categories="{{ $categories }}" :suppliers="{{ $suppliers }}" :brands="{{ $brands }}"
            :variations="{{ $variations }}" :product_info="{{ $product_info }}" :product-options="{{ $productOptions }}"
            :product-options-values="{{ $productOptionsValues }}" :auth-supplier="{{ $auth_supplier }}"></edit-product>

    </div>
@endsection

@push('js')
    <x-routes></x-routes>
    <script src="{{ mix('js/product.js') }}"></script>
@endpush
