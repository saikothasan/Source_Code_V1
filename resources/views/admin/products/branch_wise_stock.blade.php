@extends('layouts.app')
@section('title', 'Branch Wise Stock')
@section('content')
    <style>
        .header {
            color: rgb(255, 150, 0);
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
                            <h3 class="header">{{translate('Branch')}} {{translate('Wise')}} {{translate('Stock')}}</h3>
                        </div>
                    </div>
                    <form action="{{ route('branch-wise-stock', $product) }}" method="get" class="bg-none">
                        <div class="col-md-12 row text-center spacer" style="display: flex;justify-content: center">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        <input value="{{ request()->get('barcode') }}" name="barcode"
                                            class="form-control corner" placeholder="{{translate('Barcode')}}">
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        <input readonly
                                            value="SKU: {{ collect($stock->items())->first()->product_sku ?? '' }}"
                                            class="form-control corner" placeholder="{{translate('SKU')}}">
                                    </label>
                                </div>
                            </div>
                            @if (isMainBranch())
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="branch" class="form-control select2" id="branch"
                                            style="width: 100%">
                                            <option value="">Select Branch</option>
                                            @foreach (getAllBranch() as $key => $branch)
                                                <option value="{{ $branch->value }}"
                                                    {{ request()->get('branch', '') == $branch->value ? 'selected' : '' }}>
                                                    {{ $branch->text }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="form-control">{{translate('Submit')}}</button>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                <div class="form-group" style="width: 72px;">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>{{translate('SN')}}.</th>
                                <th>{{translate('Branch')}}</th>
                                <th>{{translate('Barcode')}}</th>
                                <th>{{translate('Product')}} {{translate('Name')}}</th>
                                <th>{{translate('Quantity')}}</th>
                                <th>{{translate('Sale')}}</th>
                                <th>{{translate('Available')}}</th>
                                <th>{{translate('action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stock as $value)
                                @php
                                    $variantName = null;
                                @endphp
                                @if (isset($value->productVariations->variantValues))
                                    @php
                                        $variantName = collect($value->productVariations->variantValues)
                                            ->pluck('variantValueName.variation_value')
                                            ->implode('-');
                                    @endphp
                                @endif
                                <tr>
                                    <td>{{ serialNumber($stock, $loop) }}</td>
                                    <td>{!! $value->branch->name ?? '<span class="text-red text-bold">On Hold</span>' !!}</td>
                                    <td>{{ $value->product_barcode }}</td>
                                    <td>{{ $value->product->name ?? '' }} @if (isset($variantName))
                                            -{{ $variantName }}
                                        @endif
                                    </td>
                                    <td>{{ $value->total_quantity }} {{translate('pcs')}}</td>
                                    <td>{{ $value->total_sell }} {{translate('pcs')}}</td>
                                    <td>{{ $value->available_pieces }} {{translate('pcs')}}</td>
                                    <td class="action">

                                        <a href="{{ route('product-wise-position', $value->product_barcode) }}">
                                            <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                alt="edit" />
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No product available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="4"></td>
                                <td>{{ number_format($total_quantity) }} {{translate('pcs')}}</td>
                                <td>{{ number_format($total_sell) }} {{translate('pcs')}}</td>
                                <td>{{ number_format($total_available) }} {{translate('pcs')}}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    {{ $stock->links() }}
                </div>
            </div>
    </div>
    </section>
    </div>

@endsection
