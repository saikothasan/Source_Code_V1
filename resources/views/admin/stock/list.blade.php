@extends('layouts.app')
@section('title', 'Stock List')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Dashboard
                
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('products.index') }}"><i class="fa fa-group"></i> Products</a></li>
                <li class="active">Stock</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('product.search') }}" method="get" class="form-horizontal">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Supplier</label>
                                            <select name="supplier_id" id="supplier_id" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Supplier</option>
                                                @foreach ($suppliers as $key => $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ request()->get('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label for="">Category</label>
                                            <select name="category_id" id="category_id" class="form-control select2"
                                                style="width: 100%">
                                                <option value="">Select Category</option>
                                                @foreach ($categorys as $key => $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <label for="">Product</label>
                                        <input name="product" placeholder="Product Name" class="form-control" type="text"
                                            value="{{ request()->get('product') }}">

                                    </div>

                                </div>
                                <div class="col-md-2 mt-3">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-sm bg-teal form-control">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Content Header (user header) -->
                    <div class="box box-teal box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Stock list</h3>
                            <div class="box-tools pull-right">

                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            @include('includes.errormessage')
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">Sl.</th>
                                        <th style="width: 25%;">Product</th>
                                        <th style="width: 25%;">Size</th>
                                        <th style="width: 10%;">Stock</th>
                                        <th style="width: 10%;">Sale</th>
                                        <th style="width: 10%;">Transfer</th>
                                        <th style="width: 10%;">Pro.return</th>
                                        <th style="width: 10%;">P.return</th>
                                        <th style="width: 10%;">S.return</th>
                                        <th style="width: 10%;">Available</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_stock = 0;
                                        $total_sale = 0;
                                        $total_transfer = 0;
                                        $total_Preturn = 0;
                                        $toal_ProReturn = 0;
                                        $total_Sreturn = 0;
                                        $total_available = 0;
                                    @endphp

                                    @foreach ($stocks->sortByDesc('available') as $key => $stock)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>

                                            <td class="text-lowercase">{{ $stock->product }}</td>
                                            <td class="text-lowercase">{{ $stock->size ? $stock->size : '' }}</td>
                                            <td>{{ $stock->total_quanity }} {{ $stock->unit }}</td>
                                            <td>{{ $stock->sale_quantity }} {{ $stock->unit }}</td>
                                            <td>{{ $stock->transfers_quantity }} {{ $stock->unit }}</td>
                                            <td>{{ $stock->product_return }} {{ $stock->unit }}</td>
                                            <td>{{ $stock->purchase_return }} {{ $stock->unit }}</td>
                                            <td>{{ $stock->sale_return }} {{ $stock->unit }}</td>
                                            <td>{{ $stock->available }} {{ $stock->unit }}</td>
                                        </tr>
                                        @php
                                            $total_stock += $stock->total_quanity;
                                            $total_sale += $stock->sale_quantity;
                                            $total_transfer += $stock->transfers_quantity;
                                            $toal_ProReturn += $stock->product_return;
                                            $total_Preturn += $stock->purchase_return;
                                            
                                            $total_Sreturn += $stock->sale_return;
                                            $total_available += $stock->available;
                                            
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tr style="margin-top: 10px;">
                                    <td colspan="2" style="text-align: right; font-weight: bold;">Total=</td>
                                    <td>{{ $total_stock }}</td>


                                    <td>{{ $total_sale }}</td>


                                    <td>{{ $total_transfer }}</td>


                                    <td>{{ $toal_ProReturn }}</td>


                                    <td>{{ $total_Preturn }}</td>
                                    <td>{{ $total_Sreturn }}</td>

                                    <td>{{ $total_available }}</td>


                                </tr>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
