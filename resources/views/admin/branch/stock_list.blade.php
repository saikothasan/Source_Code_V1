<form action="{{route('branch.sale',['branch' =>$branch->id, 'type' => 'stock']) }}" method="get">
    <div class="col-md-12 row text-center spacer">
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    <input value="{{request()->get('search')}}" name="search"
                           class="form-control corner" placeholder="Search">
                </label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <select name="supplier" class="form-control select2" id="supplier"
                        style="width: 100%">
                    <option value="">{{translate('Select')}} {{translate('Supplier')}}</option>
                    @foreach (getAllSupplier() as $supplier)
                        <option
                            value="{{$supplier->value}}" {{ request()->get('supplier') ==$supplier->value ? 'selected' : ''  }}>
                            {{$supplier->text}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select name="brand" class="form-control select2" id="brand"
                        style="width: 100%">
                    <option value="">{{translate('Select')}} {{translate('Brand')}}</option>
                    @foreach (getAllBrand() as $brand)
                        <option
                            value="{{$brand->value}}"
                            {{ request()->get('brand') ==$brand->value ? 'selected' : ''  }} name="brand">
                            {{$brand->text}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select class="form-control select2" id="category" name="category"
                        style="width: 100%">
                    <option value="">{{translate('Select')}} {{translate('Category')}}</option>
                    @foreach (getAllCategory() as $category)
                        <option
                            value="{{$category->value}}" {{ request()->get('category') ==$category->value ? 'selected' : ''  }}>
                            {{$category->text}}
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
<div class="card-body p-0 spacer" style="overflow-x: auto">
    <table class="table table-striped table-responsive example-table">
        <thead>
        <tr>
            <th>{{translate('SN')}}.</th>
            <th>{{translate('Barcode')}}</th>
            <th>{{translate('SKU')}}</th>
            <th>{{translate('Suppliers')}}</th>
            <th>{{translate('Product')}} {{translate('Name')}}</th>
            <th>{{translate('Item')}}</th>
            <th>{{translate('Quantity')}}</th>
            <th>{{translate('Sell')}}</th>
            <th>{{translate('Available')}}</th>
            {{-- <th>buy price</th> --}}

            <th></th>
        </tr>
        </thead>
        <tbody>

        @forelse($branch_product['products']->items() as $value)

            @php
                $variantName = null;
            @endphp
            @if(isset($value->productVariations->variantValues))
                @php
                    $variantName = collect($value->productVariations->variantValues)->pluck('variantValueName.variation_value')->implode('-');
                @endphp
            @endif
            <tr>
                <td>{{ serialNumber($branch_product['products'],$loop) }}</td>
                <td>{{$value->product_barcode}}</td>
                <td>{{$value->product_sku}}</td>
                <td>{{$value->product->supplier->name ?? ''}}</td>
                <td>{{$value->product->name ?? ''}} @if(isset($variantName))
                        -{{$variantName}}
                    @endif</td>
                <td>{{ collect($branch_product['products']->items())->where('product_id', $value->product_id)->count() }}</td>
                <td>{{$value->total_quantity}} pcs</td>
                <td>{{$value->total_sale}} pcs</td>
                <td>
                    @php
                        $available = $value->total_quantity-$value->total_sale
                    @endphp
                    @if($available > 5)
                        {{$available}} pcs
                    @else
                        <span style="color:red">{{$available}} {{translate('pcs')}} </span>
                    @endif
                </td>
                {{-- <td>{{ $value->product->buy_price }}</td> --}}

                <td class="action">

                    <a href="{{route('product-wise-position',$value->product_barcode)}}">
                        <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                             alt="edit"/>
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
        <br>
        <tr>
            <td colspan="5" style="text-align: end">{{translate('Total')}} =</td>
            <td>{{ $branch_product['total_items'] }}</td>

            <td>{{$branch_product['total_quantity']  }}</td>
            <td>{{$branch_product['sell_total']  }} {{get_settings('currency_symbol')}}</td>
            <td>{{$branch_product['available_total']  }}</td>
            <td></td>
        </tr>
        </tbody>
        </tbody>
    </table>
    {{$branch_product['products']->links()}}
</div>
