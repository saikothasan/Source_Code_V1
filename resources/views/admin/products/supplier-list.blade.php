@extends('layouts.app')
@section('title', 'View Product')
@section('content')
    <style>
        .header {
            color: rgb(2, 2, 2);
        }

        .corner {
            border-radius: 7px;
            text-align: center;
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
            color: rgb(153, 153, 153);
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light';
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{translate('View')}} {{translate('Product')}}</h3>
                        </div>
                    </div>
                    <form action="{{ route('products.index') }}" method="get">
                        <div class="col-md-12 row text-center spacer" style="display: flex;justify-content: center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        <input value="{{ request()->get('search') }}" name="search"
                                            class="form-control corner" placeholder="Search">
                                    </label>
                                </div>
                            </div>
                            {{--                                <div class="col-md-3"> --}}
                            {{--                                    <div class="form-group"> --}}
                            {{--                                        <label> --}}
                            {{--                                            <input value="{{request()->get('sku')}}" name="sku" --}}
                            {{--                                                   class="form-control corner" placeholder="SKU"> --}}
                            {{--                                        </label> --}}
                            {{--                                    </div> --}}
                            {{--                                </div> --}}
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="brand" class="form-control select2" id="brand" style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Brand')}}</option>
                                        @foreach (getAllBrand() as $brand)
                                            <option value="{{ $brand->value }}"
                                                {{ request()->get('brand') == $brand->value ? 'selected' : '' }}>
                                                {{ $brand->text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="category" class="form-control select2" id="category" style="width: 100%">
                                        <option value="">{{translate('Select')}} {{translate('Category')}}</option>
                                        @foreach (getAllCategory() as $category)
                                            <option value="{{ $category->value }}"
                                                {{ request()->get('category') == $category->value ? 'selected' : '' }}>
                                                {{ $category->text }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group" style="width: 72px;">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group" style="width: 72px;">
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>{{translate('Barcode')}}</th>
                                <th>{{translate('SKU')}}</th>
                                <th>{{translate('Product')}} {{translate('Name')}}</th>
                                <th>{{translate('Quantity')}}</th>
                                <th>{{translate('Main')}} {{translate('Branch')}}</th>
                                <th>{{translate('Sell')}}</th>
                                <th>{{translate('Avilable')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $value)
                                <tr>
                                    <td>{{ serialNumber($products, $loop) }}</td>
                                    <td>{{ $value->product_code }}</td>
                                    <td>{{ $value->product_sku }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->product_stock_count }} pcs</td>
                                    <td>{{ $value->available_main_branch }} pcs</td>
                                    <td>{{ $value->total_sell }} pcs</td>
                                    <td>
                                        @php
                                            $available = $value->product_stock_count - $value->total_sell;
                                        @endphp
                                        @if ($available > 5)
                                            {{ $available }} {{translate('pcs')}}
                                        @else
                                            <span style="color:red">{{ $available }} {{translate('pcs')}} </span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <a href="{{ route('products.edit', $value->id) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="{{ route('branch-wise-stock', $value->id) }}">
                                            <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="edit" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No')}} {{translate('product')}} {{translate('available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                            <br>
                            <tr>
                                <td colspan="4" style="text-align: end">{{translate('Total')}} =</td>
                                <td>{{ number_format($total_quantity) }}</td>
                                <td>{{ number_format($available_main_branch) }}</td>
                                <td>{{ number_format($sell_total) }}</td>
                                <td>{{ number_format($available_total) }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
