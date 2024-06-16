<table style="width: 100%;">
    <tbody>
    @foreach($sale->saleProducts as $value)
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
            <td class="description">{{$value->product->name}}@if(isset($variantName))-{{$variantName}}
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
                <u>{!! collect($sale->salePayment->payments)->pluck('payment_method.text')->implode('<br>') !!}</u>
            </div>
        </td>
        <td>
            <p>Amount</p>
            <p>Vat ({{$sale->vat_percentage}}%)</p>
            @if($sale->delivery_id)
                <p>Delivery Charge</p>
            @endif
            @if($sale->additional_charge > 0)
                <p>Additional Charge</p>
            @endif
            <p>Total</p>
            <p>Discount</p>
            <p>Total Amount</p>
            <p>Paid</p>
            <p>Due</p>
            <p>Change Amount</p></td>
        <td>
            <p class="left">{{formatWithComma($sale->product_total)}}</p>
            <p class="left">{{formatWithComma($sale->vat_amount)}}</p>
            @if($sale->delivery_id)
                <p class="left">
                    {{formatWithComma($sale->delivery_charge+$sale->additional_delivery_charge)}}</p>
            @endif
            @if($sale->additional_charge > 0)
                <p class="left">
                    {{formatWithComma($sale->additional_charge)}}</p>
            @endif
            <p class="left">
                {{ formatWithComma($sale->product_total+$sale->additional_charge+$sale->vat_amount+$sale->delivery_charge+$sale->additional_delivery_charge)}}
            </p>
            <p class="left">{{formatWithComma($sale->discount_amount+$sale->flat_discount)}}</p>
            <p class="left">{{formatWithComma($sale->net_total)}}</p>
            <p class="left">{{formatWithComma($sale->pay_amount)}}</p>
            <p class="left">{{formatWithComma($sale->due_total)}}</p>
            <p class="left">{{formatWithComma($sale->change_amount)}}</p></td>
    </tr>
    </tbody>
</table>
