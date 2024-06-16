<div class="table-size">
    <h4 class="font-weight-bold" style="border-bottom: 1px solid #49505c;width: 18%;font-weight: 700;">Received
        Product</h4>
    <span></span>
    <div style="display: grid;">
        <span>{{date('d F Y',strtotime($received->date))}} (Invoice No - {{$received->invoice_code}})</span>
        <span>{{$received->sendUser->name ?? ''}} @if(isset($received->sendUser->designation->name))
                ({{$received->sendUser->designation->name}})
            @endif</span>
        <span>Send by {{$received->sendBranch->name ?? ''}}</span>
        <div>
            @if($received->invoice_type===1 && $received->status ===0)
                <span class="label label-warning">Receive Pending ({{$received->receiveBranch->name ?? ''}})</span>
            @elseif($received->status ===1)
                <span>Receive by {{$received->receiveUser->name ?? ''}} ({{$received->receiveBranch->name ?? ''}})</span>
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
        @foreach($received->productDetails as $value)
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
        <h4 class="text-right">{{$received->total_quantity}} Pcs Product Total Purchase Amount :
            : {{$received->total}}</h4>
        <h4 class="text-left">In Word :
            {{numberToWords($received->total)}}
            only</h4>
    </div>


    <div style="margin-top: 15%;">
        <div>
            <h4 class="text-black">Signature
            </h4>
            {{-- @php
                echo DNS1D::getBarcodeSVG($received->invoice_code, 'C128A',1,50);
            @endphp --}}
                   @php
                   echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($received->invoice_code, 'C128A',1,50) . '" alt="barcode"   />';


                  @endphp
                  <p style="margin-left:3%;">  {{ $received->invoice_code }}</p>
        </div>
    </div>


    <div class="print-link" style="padding: 11%;text-align: center;">
        <div>
            <a href="{{route('received.download',$received->id)}}"  class="hidden-print">
                <button type="submit" style="margin-right: 20px;border-color: #000000;background: white;"
                        class="btn btn-default text-black download pointer hidden-print">Download
                </button>
            </a>
            <a href="{{route('received.print',$received->id)}}" class="hidden-print"
               target="@if(route('received.print',$received->id)) '_blank' @endif">
                <button type="submit" style="color: black;border-color: #000000;background: white;"
                        class="btn text-black print pointer hidden-print">Print
                </button>
            </a>

        </div>
    </div>
</div>
