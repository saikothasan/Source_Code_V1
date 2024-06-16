@extends('layouts.app')
@section('title', 'Variation List')
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
            text-align: center;
            vertical-align: middle !important;
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
            border-radius: 5px;
            right: 0;
            z-index: 9;
            border: none;
            top: 1px;
            cursor: pointer;
            color: #423030;
        }

        .font {
            font-family: 'Roboto Light';
        }

        .custom-home {
            padding: 8px 59px;
            font-size: 18px;
            line-height: 1.3333333;
        }

        .variation-value {
            display: flex;
            /*justify-content: space-between;*/
            margin-bottom: 10px;
            border-bottom: 1px solid #c7bcbc;
        }

        .form-group {
            color: #000000;
        }

        .form-control {
            color: #000000 !important;
        }

        .custom-box {
            width: 100%;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h1>{{translate('Variation')}} {{translate('List')}}</h1>
                        </div>
                    </div>
                </div>

                <div class="row spacer ">
                    <div class="col-md-12">
                        @if (isset($variation_value))
                            <form method="POST" action="{{ route('variation-value.update', $variation_value->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="custom-box">
                                    <div class="box-body">
                                        <h4 class="text-center text-bold" style="padding-bottom: 20px;">{{translate('Variation')}} {{translate('Value')}}
                                            {{translate('Update')}}</h4>
                                        <div>
                                            <div class="col-xs-12">
                                                <div class="form-group"><label for="description">Variant</label>
                                                    <input type="text" readonly placeholder="{{translate('Variation')}} {{translate('value')}}"
                                                        class="form-control corner"
                                                        value="{{ $variation_value->variantType->variation_name }}">
                                                </div>
                                                <input type="hidden" class="form-control corner" name="type_id"
                                                    value="{{ $variation_value->type_id }}">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="col-xs-12">
                                                <div class="form-group"><label for="description">{{translate('Variation')}} {{translate('Value')}}</label>
                                                    <input type="text" placeholder="{{translate('Variation')}} {{translate('value')}}"
                                                        class="form-control corner" name="variation_value"
                                                        value="{{ $variation_value->variation_value }}">
                                                </div>
                                            </div>
                                        </div>
                                        @if (strtolower($variation_value->variantType->variation_name) == 'color')
                                            <div>
                                                <div class="col-xs-12">
                                                    <div class="form-group"><label for="description">Variation Code</label>
                                                        <input type="color" placeholder="{{translate('Variation')}} {{translate('value')}}"
                                                            class="form-control corner" name="variation_code"
                                                            value="{{ $variation_value->variation_code }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="box-footer text-center">
                                        <button type="submit" class="btn btn-primary">{{translate('Update')}}</button>
                                    </div>
                                </div>
                            </form>
                        @elseif (isset($variation))
                            <form method="POST" action="{{ route('variation.update', $variation->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group custom-btn">
                                    <input type="text" placeholder="{{translate('Variation')}} {{translate('Name')}}" class="form-control corner"
                                        name="variation_name" value="{{ $variation->variation_name }}">
                                    @error('variation_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button class="btn btn-success custom-add font" type="submit">{{translate('Update')}}</button>
                                </div>
                            </form>
                        @else
                            <form method="POST" action="{{ route('variation.store') }}">
                                @csrf
                                <div class="form-group custom-btn">
                                    <input  placeholder="{{translate('Variation')}} {{translate('Name')}}" type="text" class="form-control corner"
                                        name="variation_name">
                                    <button class="btn btn-success custom-add font" type="submit">{{translate('Add')}}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                @include('includes.errormessage')`
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th class="text-center">{{translate('Name')}}</th>
                                <th class="text-center">{{translate('Variation')}} {{translate('Values')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($variations as $key => $value)
                                <tr>
                                    <td style="vertical-align: middle !important;">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle !important;">{{ $value->variation_name }}</td>
                                    <td>
                                        <table>
                                            @if (isset($value->variationValue))
                                                @foreach ($value->variationValue->chunk(3) as $chunk)
                                                    <div class="variation-value col-md-12">
                                                        @foreach ($chunk as $variationValue)
                                                            <div class="col-md-4">
                                                                <div class="row" style="white-space: nowrap;">
                                                                    <div class="col-md-6">
                                                                        <span>{{ $variationValue->variation_value }}</span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <a
                                                                            href="{{ route('variation.show', $variationValue->id) }}">
                                                                            <span class=""><i
                                                                                    class="fa fa-edit"></i></span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            @endif
                                        </table>
                                    </td>
                                    <td class="action">
                                        <div style="margin-bottom: 12px;">
                                            <a class="btn btn-block btn-primary btn-sm" href="#" data-toggle="modal"
                                                data-target="#add-variation-value-modal" data-id="{{ $value->id }}"
                                                data-variation_name="{{ $value->variation_name }}">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </a>
                                        </div>
                                        <a href="{{ route('variation.edit', $value->id) }}">
                                            <button class="btn btn-block btn-success btn-sm"> {{translate('Edit')}}</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    </section>
    </div>
    {{-- Add Variation Value --}}
    <div class="modal fade" id="add-variation-value-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{translate('New')}} {{translate('Variation')}} {{translate('Value')}}</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('variation-value.store') }}" method="POST" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="type_id" id="type_id" />
                        <div class="form-group">
                            <label class="control-label col-md-3">{{translate('Variation')}} {{translate('Name')}}</label>
                            <div class="col-sm-9">
                                <input name="variation_name" readonly id="add_variation_name"
                                    placeholder="{{translate('Variation')}} {{translate('Value')}}" class="form-control" required="" type="text"
                                    value="{{ old('variation_name') }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{translate('Variation')}} {{translate('Value')}}</label>
                            <div class="col-sm-9">
                                <input name="variation_value" id="variation_value" placeholder="{{translate('Variation')}} {{translate('Value')}}"
                                    class="form-control" required="" type="text"
                                    value="{{ old('variation_value') }}" />
                            </div>
                        </div>
                        <div class="form-group" id="codeShow">
                            <label class="control-label col-md-3">{{translate('Variation')}} {{translate('Code')}}</label>
                            <div class="col-sm-9">
                                <input name="variation_code" id="variation_code" placeholder="{{translate('Variation')}} {{translate('Code')}}"
                                    class="form-control" type="color" value="{{ old('variation_code') }}" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <center>
                                <button type="reset" class="btn btn-sm bg-red" data-dismiss="modal">{{translate('Reset')}}</button>
                                <button type="submit" class="btn btn-sm bg-teal">{{translate('Save')}}</button>
                            </center>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $('#add-variation-value-modal').on("show.bs.modal", function(event) {
            let e = $(event.relatedTarget);
            let type_id = e.data('id');
            let variation_name = e.data('variation_name');
            console.log(variation_name);
            $("#codeShow").hide();
            if (variation_name == 'Color') {
                $("#codeShow").show();
            }
            $("#type_id").val(type_id);
            $("#add_variation_name").val(variation_name);

        });
    </script>
@endpush
