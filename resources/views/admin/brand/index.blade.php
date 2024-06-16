@extends('layouts.app')
@section('title', 'Brand')
@section('content')
    <style>
        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .spacer {
            margin-top: 20px;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            /* font-family: 'Roboto Light'; */
        }

        .button-size {
            padding: 2px 13px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .custom-btn {
            position: relative;
        }

        .custom-add {
            position: absolute;
            top: 0;
            border-radius: 5px;
            right: 35px;
            z-index: 9;
            border: none;
            top: 2px;
            height: 30px;
            cursor: pointer;
            color: #423030;
            background-color: transparent;
            transform: translateX(2px);
        }

        .font {
            font-family: 'Roboto Light';
        }

        .custom-home {
            padding: 8px 59px;
            font-size: 18px;
            line-height: 1.3333333;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h1>{{ translate('Brand') }} {{ translate('List') }}</h1>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto">
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>{{ translate('SN') }}#</th>
                                <th>{{ translate('Name') }}</th>
                                <th>{{ translate('Items') }}</th>
                                <th>{{ translate('Total') }} {{ translate('Product') }}</th>
                                <th>{{ translate('Available') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $key => $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ number_format($value->total_items) }}</td>
                                    <td>{{ number_format($value->total_variants_count) }}</td>
                                    <td>{{ number_format($value->available_stocks_count) }}</td>
                                    <td class="action">
                                        <a href="{{ route('brand.edit', $value->id) }}">
                                            <button class="button-size font"> {{ translate('Edit') }}</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row spacer ">
                    <div class="col-md-12">
                        @if (isset($brand))
                            <form method="POST" action="{{ route('brand.update', $brand->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group custom-btn">
                                    <input type="text" class="form-control corner" name="name"
                                        value="{{ $brand->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button class="btn custom-add font bg-green"
                                        type="submit">{{ translate('Update') }}</button>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('brand.store') }}">
                                @csrf
                                <div class="form-group custom-btn">
                                    <input type="text" class="form-control corner" name="name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button class="btn custom-add font bg-green"
                                        type="submit">{{ translate('Add') }}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
