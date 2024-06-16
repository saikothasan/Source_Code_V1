<div class="table-size">
    <h4 class="font-weight-bold" style="border-bottom: 1px solid #49505c;width: 18%;font-weight: 700;">Transfer
        Product</h4>
    <span></span>
    <div style="display: grid;">
        <span>{{date('d F Y',strtotime($transfer->date))}} (Invoice No - {{$transfer->invoice_code}})</span>
        <span>{{$transfer->sendUser->name ?? ''}} @if(isset($transfer->sendUser->designation->name)) ({{$transfer->sendUser->designation->name}}) @endif</span>
        <span>
             Send By {{$transfer->sendBranch->name ?? ''}}
        </span>
        <div>
            @if($transfer->invoice_type===1 && $transfer->status ===0)
                <span class="label label-warning">Receive Pending ({{$transfer->receiveBranch->name ?? ''}})</span>
            @elseif($transfer->invoice_type===1 && $transfer->status ===1)
                <span>Receive by {{$transfer->receiveUser->name ?? ''}} ({{$transfer->receiveBranch->name ?? ''}})</span>
            @elseif($transfer->invoice_type===2 && $transfer->status ===1)
                <span>Receive by {{$transfer->receiveUser->name ?? ''}} ({{$transfer->receiveBranch->name ?? ''}})</span>
            @elseif($transfer->status ===2)
                <span class="label label-danger">Transfer Reject {{$transfer->receiveUser->name ?? ''}} ({{$transfer->receiveBranch->name ?? ''}})</span>
            @endif
        </div>

    </div>
    <table class="table table-bordered" style="margin-top: 18px;">
        <tbody>
        <tr>
            <th>Product Name</th>
            <th>SKU</th>
            <th>Barcode</th>
            <th>Quantity</th>
            <th>Amount</th>
        </tr>
        @foreach($transfer->productDetails as $value)
            @php
                $variantName = null;
            @endphp
            <tr>
                @if(isset($value->productVariations->variantValues))
                    @php
                        $variantName = collect($value->productVariations->variantValues)->pluck('variantValueName.variation_value')->implode('-');
                    @endphp
                @endif
                <td>{{$value->product->name}}@if(isset($variantName))
                        -{{$variantName}}
                    @endif
                </td>
                <td>{{$value->product_sku}}</td>
                <td>{{$value->product_barcode}}</td>
                <td>{{$value->quantity}} pcs</td>
                <td>{{$value->total}} {{get_settings('currency_symbol')}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        <h4 class="text-right">{{$transfer->total_quantity}} Pcs Product Total Purchase Amount :
            : {{$transfer->total}}</h4>
        <h4 class="text-left">In Word :
            {{numberToWords($transfer->total)}}
            only</h4>
    </div>


    <div style="margin-top: 15%;">
        <div>
            <h4 class="text-black">Signature
            </h4>
            {{-- @php
                echo DNS1D::getBarcodeSVG($transfer->invoice_code, 'C128A',1,50);
            @endphp --}}
                @php
                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($transfer->invoice_code, 'C128A',1,50) . '" alt="barcode"   />';


               @endphp
               <p style="margin-left:3%;">  {{ $transfer->invoice_code }}</p>
        </div>
    </div>


    <div class="print-link" style="padding: 11%;text-align: center;">
        <div>
            <a href="{{route('transfer.download',$transfer->id)}}"  class="hidden-print">
                <button type="submit" style="margin-right: 20px;border-color: #000000;background: white;"
                        class="btn btn-default text-black download pointer hidden-print">Download
                </button>
            </a>
            <a href="{{route('transfer.print',$transfer->id)}}"
               target="@if(route('purchase.print',$transfer->id)) '_blank' @endif">
                <button type="submit" style="color: black;border-color: #000000;background: white;"
                        class="btn text-black print pointer">Print
                </button>
            </a>

        </div>
    </div>
</div>
