@foreach($sale->exchanges as $exchange)
    <p class="text-center" style="margin-top: 5%;">Exchange :
        {{date('d F y',strtotime($exchange->date))}}</p>

    @if($exchange->delivery_id)
        <div class="row">
            <div class="col-md-12 text-left"> Delivery :
                {{$exchange->deliveryMan->name}}
            </div>
        </div>
    @endif
    <table style="width: 100%;">
        <tbody>
        @foreach($exchange->saleProducts as $value)
            @php
                $variantName = null;
            @endphp
            @if(isset($value->productVariations->variantValues))
                @php
                    $variantName = collect($value->productVariations->variantValues)->pluck('variantValueName.variation_value')->implode('-');
                @endphp
            @endif
            <tr style="border-bottom: 1px dashed black; border-collapse: collapse;">
                <td class="mrp">{{$loop->index +1}}.</td>
                <td class="description">{{$value->product->name}}@if(isset($variantName))
                        -{{$variantName}}
                    @endif X {{formatWithComma($value->quantity)}}
                </td>
                <td class="price"> = {{formatWithComma($value->product_total)}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>

    <table class="not-dashed" style="width: 100%;margin-top: 5px;">
        <tbody>
        <tr>
            <td style="vertical-align: baseline;">
                <div style="display:grid">
                    @if(isset($exchange->exchangePayment))
                        <u>{!! collect($exchange->exchangePayment->payments)->pluck('payment_method.text')->implode('<br>') !!}</u>
                    @endif
                </div>
            </td>
            <td>
                <p>Amount</p>
                <p>Vat ({{$exchange->vat_percentage}}%)</p>
                @if($exchange->delivery_id)
                    <p>Delivery Charge</p>
                @endif
                <p>Total</p>
                <p>Discount</p>
                <p>Total Amount</p>
                <p>Paid</p>
                <p>Due</p>
                <p>Change Amount</p></td>
            <td>
                @php
                    $product_total = collect($exchange->saleProducts)->sum('product_total');
                @endphp
                <p class="left">{{formatWithComma($product_total)}}</p>
                <p class="left">{{formatWithComma($exchange->vat_amount)}}</p>
                @if($exchange->delivery_id)
                    <p class="left">
                        {{formatWithComma($exchange->delivery_charge)}}</p>
                @endif
                <p class="left">
                    {{ formatWithComma($product_total+$exchange->vat_amount+$exchange->delivery_charge)}}
                </p>
                <p class="left">{{formatWithComma($exchange->discount_amount+$exchange->flat_discount)}}</p>
                <p class="left">{{formatWithComma($exchange->net_total)}}</p>
                <p class="left">{{formatWithComma($exchange->pay_amount)}}</p>
                <p class="left">{{formatWithComma($exchange->due_total)}}</p>
                <p class="left">{{formatWithComma($exchange->change_amount)}}</p></td>
        </tr>
        </tbody>
    </table>
@endforeach
