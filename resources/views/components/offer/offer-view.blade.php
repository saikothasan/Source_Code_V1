<div class="table-size" id="print">
    <h4 class="font-weight-bold" style="font-weight: 700;">{{$offer->title}}</h4>
    <span></span>
    <div style="display: grid;" class="header-option">
        <span>
            Offer Duration {{dateDifference($offer->end_date,$offer->start_date)['days']}} Days
            ( Start {{date('d F ',strtotime($offer->start_date))}} or Expired {{date('d F ',strtotime($offer->end_date))}} )
        </span>
        <span>This Offer is Provided By Only {{$offer->supplier->name ?? 'Colourful Management'}} </span>
        <span>Created By {{$offer->createdBy->name ?? ''}}</span>
    </div>
    @if($offer->supplier!== null && $offer->status === \App\Model\Offer::STATUS['inactive'])
        <span class="label label-info">
            {{$offer->supplier->name !== null  ? 'Requested': ''}}
        </span>
        &nbsp;&nbsp;
    @endif
    {!! $offer->status_text !!}

    <table class="table table-bordered" style="margin-top: 18px;">
        <tbody>
        <tr>
            <th>S.N</th>
            <th>Product Name</th>
            <th>Barcode</th>
            <th>In Stock</th>
            <th>Purchase Price</th>
            <th style="{{ (int)$offer->type === 5 ? 'display:none':''}}">Discount</th>
            <th>Quantity</th>
        </tr>
        @foreach($offer->offerProducts as $value)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{$value->product->name}} {{$value->product_type === 1 ? "(Buy)":""}} {{$value->product_type === 2 ? "(Get)":""}}</td>
                <td>{{$value->product_barcode}}</td>
                <td>{{number_format($value->available_stock)}}</td>
                <td>{{number_format($value->product_buy_price, 2, '.', '')}}</td>
                <td style="{{ (int) $offer->type === 5 ? 'display:none' :''}} ">{{number_format($value->discount_amount, 2, '.', '')}}</td>
                <td>{{number_format($value->quantity)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="row">
        <h4 class="col-md-6 text-right">Total Purchase Price {{number_format($offer->total_purchase_price)}} -
            ({{number_format($offer->total_stock_quantity)}}pcs)</h4>
        <h4 class="col-md-6 text-left">Total Discount Price {{number_format($offer->total_discount_price)}} -
            ({{number_format($offer->total_discount_quantity)}}pcs)</h4>
    </div>

    <div style="padding: 11%;text-align: center;" class="print-barcode">
        <div>
            <a>
                <button type="submit" style=" margin-right: 20px;color: black;border-color: #000000;background: white;"
                        class="btn text-black print pointer hidden-print" onclick='printDiv("print")'>Print
                </button>
            </a>
            <a>
                <button type="submit"
                        class="btn text-black print pointer hidden-print"
                        style="color: black;border-color: #000000;background: white;"> Download
                </button>
            </a>
        </div>
    </div>
</div>
