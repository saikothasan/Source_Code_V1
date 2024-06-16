@extends('layouts.app')
@section('title', 'Transfer Product')
@section('content')
    <div class="content-wrapper" id="app">
        <div class="content">
            <form>
                <div class="custom-box ">
                    <div class="box-body">
                        <h4 class="text-center text-bold" style="padding-bottom: 20px;">Transfer Prodcut</h4>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="date" class="form-control text-center" placeholder="Enter text">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control text-center" value="CFP - 13060001"
                                            placeholder="Enter text">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input disabled type="text" class="form-control text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row div-center ">
                            <div class="col-md-12">
                                <div class="col-xs-4">

                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <input type="text" name="product_sku" class="form-control text-center"
                                            placeholder="SKU">
                                    </div>
                                </div>
                                <div class="col-xs-4">

                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 11px;">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <span class="text-danger ">
                                    </span>
                                    <div style="text-align: center; font-size: 20px">
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Barcode</th>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th class="text-center" style="width: 15%;">Quantity</th>
                                    <th class="text-center">Total Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">
                                        <div class="input-group ">
                                            <input type="number" min="1" step="1"
                                                class="form-control text-center">
                                        </div>
                                    </td>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        <a>Edit</a>
                                        <i class="fa fa-trash red-color pointer"></i>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        {{-- <div class="text-center" style="margin-top: 17px;">
                            Margin : % &nbsp;&nbsp; &nbsp;&nbsp;Profit : BDT
                            &nbsp;&nbsp;&nbsp;&nbsp;Total
                            Purchase Amount : BDT  {{get_settings('currency_symbol')}}
                        </div> --}}

                    </div>
                    <div class="row div-center " style="padding: 25px;">
                        <div class="col-md-12">
                            <div class="col-xs-4"> </div>
                            <div class="col-xs-4">
                                <div class="form-group ">
                                    <label for="exampleInputPassword1">Send</label>
                                    <input type="text" class="form-control" value="Romo" placeholder="Enter text">
                                </div>
                            </div>
                            <div class="col-xs-4"></div>
                        </div>
                    </div>
                </div>
        </div>
        <div style="margin-top: 30px;text-align: center;">
            <div>
                <button type="submit" style="margin-right: 20px;border-color: #ff9600;background: white;"
                    class="btn btn-default text-black">Save
                </button>
                <button type="submit" style="color: white" class="btn bg-orange-color text-white">Send</button>
            </div>
        </div>
        <div style="margin-top: 30px;text-align: center;">
            <div>
                <a href="{{ route('home') }}"> <button type="submit" style="color: white"
                        class="btn btn-info text-white">Home</button> </a>

            </div>
        </div>
        </form>
    </div>
    </div>

@endsection
