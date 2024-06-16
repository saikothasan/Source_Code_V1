<div class="table-size">
    <h4 class="font-weight-bold" style="border-bottom: 1px solid #49505c;width: 18%;font-weight: 700;">
        {{ translate('Product') }} {{ translate('Purchase') }}</h4>
    <span></span>
    <div style="display: grid;" class="header-option">
        <span>{{ date('d F Y', strtotime($purchase->date)) }} ({{ translate('Invoice') }} {{ translate('No') }} -
            {{ $purchase->invoice }})</span>
        <span>{{ $purchase->user->name }}</span>
        <span>{{ translate('Send By') }} {{ $purchase->send_by }}</span>
        <span>{{ translate('Receive by') }} {{ $purchase->receive->name }}</span>
    </div>
    <table class="table table-bordered" style="margin-top: 18px;">
        <tbody>
            <tr>
                <th>{{ translate('Product') }} {{ translate('Name') }}</th>
                <th>{{ translate('SKU') }}</th>
                <th>{{ translate('Barcode') }}</th>
                <th>{{ translate('Quantity') }}</th>
                <th>{{ translate('Amount') }}</th>
            </tr>
            @foreach ($purchase->purchaseDetails as $value)
                @php
                    $variantName = null;
                @endphp
                <tr>
                    @if (isset($value->productVariations->variantValues))
                        @php
                            $variantName = collect($value->productVariations->variantValues)
                                ->pluck('variantValueName.variation_value')
                                ->implode('-');
                        @endphp
                    @endif
                    <td>{{ $value->product->name }}@if (isset($variantName))
                            -{{ $variantName }}
                        @endif
                    </td>
                    <td>{{ $value->product_sku }}</td>
                    <td>{{ $value->product_barcode }}</td>
                    <td>{{ $value->quantity }} pcs</td>
                    <td>{{ number_format($value->total) }} {{ get_settings('currency_symbol') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <h4 class="text-right"> {{ number_format($purchase->purchase_details_count) }} Items
            {{ number_format($purchase->total_quantity) }} Pcs Product Total Purchase Amount :
            : {{ number_format($purchase->total) }}</h4>
        <h4 class="text-left">{{ translate('In Word') }} :
            {{ numberToWords($purchase->total) }}
            only</h4>
    </div>


    <div style="margin-top: 15%;">
        <div>
            <h4 class="text-black">{{ translate('Signature') }}
            </h4>
            @php
                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($purchase->invoice, 'C128A', 1, 50) . '" alt="barcode"   />';
                
            @endphp
            <p style="margin-left:3%;"> {{ $purchase->invoice }}</p>
        </div>
    </div>


    <div style="padding: 11%;text-align: center;" class="print-barcode">
        <div>
            <a href="{{ route('purchase.barcode', $purchase->id) }}" target="_blank">
                <button type="submit" style="margin-right: 20px;border-color: #000000;background: white;"
                    class="btn btn-default text-black download pointer">{{ translate('Barcode') }}
                </button>
            </a>
            <a href="{{ route('purchase.print', $purchase->id) }}"
                target="@if (route('purchase.print', $purchase->id)) '_blank' @endif">
                <button type="submit" style=" margin-right: 20px;color: black;border-color: #000000;background: white;"
                    class="btn text-black print pointer">{{ translate('Print') }}
                </button>
            </a>

            <a href="{{ route('purchase.download', $purchase->id) }}">
                <button type="submit" class="btn text-black print pointer"
                    style="color: black;border-color: #000000;background: white;"> {{ translate('Download') }}</button>
            </a>

        </div>
    </div>
</div>
