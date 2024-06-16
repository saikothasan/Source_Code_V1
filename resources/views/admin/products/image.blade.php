@extends('layouts.app')
@section('title', 'Image Upload - '. $product['name'])
@section('content')
    @push('css')
        <style>
            .image-list {
                border: 2px solid #9b8c8c;
                border-radius: 1px;
                margin-left: 2px;
                cursor: pointer;
            }

            .div-center {
                display: flex;
                justify-content: center;
            }
        </style>
    @endpush
    <div class="content-wrapper" id="product">
        <product-image
            :product-info="{{ json_encode($product) }}"
            :product-options="{{ json_encode($productOptions)  }}"
            :product-options-values="{{ json_encode($productOptionsValues)  }}">
        </product-image>
    </div>
@endsection

@push('js')
    <x-routes></x-routes>
    <script src="{{mix('js/product.js')}}"></script>
@endpush
