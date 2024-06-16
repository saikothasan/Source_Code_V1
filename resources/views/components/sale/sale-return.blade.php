@foreach($sale->saleReturns as $return)
    <p class="text-center" style="margin-top: 5%;">{{$return->type_name}} :
         {{date('d F y',strtotime($return->return_date))}}</p>
    <table style="width: 100%;">
        <tbody>
        @foreach($return->returnProducts as $return_product)
            @php
                $variantName = null;
            @endphp
            @if(isset($return_product->productVariations->variantValues))
                @php
                    $variantName = collect($return_product->productVariations->variantValues)->pluck('variantValueName.variation_value')->implode('-');
                @endphp
            @endif
            <tr style="border-bottom: 1px dashed black; border-collapse: collapse;">
                <td class="mrp">{{$loop->index +1}}.</td>
                <td class="description">{{$return_product->product->name}}@if(isset($variantName))-{{$variantName}}
                    @endif X {{formatWithComma($return_product->quantity)}}
                </td>
                <td class="price"> = {{formatWithComma($return_product->product_total)}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <table class="not-dashed" style="width: 100%;margin-top: 5px;">
        <tbody>
        <tr>
{{--            <td style="vertical-align: baseline;">--}}
{{--                <div style="display:grid">--}}
{{--                    <u>{!! collect($sale->salePayment->payments)->pluck('payment_method.text')->implode('<br>') !!}</u>--}}
{{--                </div>--}}
{{--            </td>--}}
            <td>
                <p>Total</p>
                <p>Vat ({{$return->vat_percentage}}%)</p>
                <p>Discount</p>
                <p>Return</td>
            <td>
                <p class="left">{{formatWithComma(collect($return->returnProducts)->sum('product_total'))}}</p>
                <p class="left">{{formatWithComma($return->vat_amount)}}</p>
                <p class="left">{{formatWithComma($return->discount_amount+$return->flat_discount)}}</p>
                <p class="left">{{formatWithComma($return->return_total)}}</p>
        </tr>
        </tbody>
    </table>
@endforeach
