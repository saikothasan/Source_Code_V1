<div class="ticket invoice invoice-font invoice-border" style="margin: auto;">
    <div class="text-center">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(getSetting('print_logo', 'images/logoheader.png')))) }}"
            alt="" class="image">
    </div>

    <p class="centered">
        <br>
        <strong>
            {{ $sale->branch->address }}
        </strong>
    </p>
    @if (isset($sale->branch) && $sale->branch->name != 'ONLINE BRANCH')
        <div style="margin-bottom: 7px;display: flex; justify-content: space-between;">
            <div style="font-size: 13px;">
                Vat Reg No# 004452563-0202
            </div>
            <div style="font-size: 13px;text-align: end;">
                Mushak-6.3
            </div>
        </div>
    @endif
    <p class="bill">Invoice</p>
    <h4 class="text-center"><strong> {{ $sale->invoice_code }} </strong></h4>
    <div class="text-center" style="padding-bottom: 5px;">
        {{ date('d F y - h : i A', strtotime($sale->created_at)) }}
    </div>
    <div style="display: flex;justify-content: space-between;">
        <div>
            {{ $sale->customer->phone }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $sale->customer->name }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-left">
            {{ $sale->customer_address }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-left">
            Seller: {{ $sale->seller->name }}
        </div>
    </div>
    @if ($sale->delivery_id)
        <div class="row">
            <div class="col-md-12 text-left"> Delivery :
                {{ $sale->delivery->name }}
            </div>
        </div>
    @endif

    <br>
    <x-sale.sale-information :sale="$sale"></x-sale.sale-information>
    <x-sale.sale-return :sale="$sale"></x-sale.sale-return>
    <x-sale.sale-new-exchange :sale="$sale"></x-sale.sale-new-exchange>
    <div class=" footer">
        <div class="row">
            <div class="col-md-12">
                @php
                    //echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($sale->invoice_code, 'C39',1,33) . '" alt="barcode"   />';
                    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($sale->invoice_code, 'C128A', 1, 33) . '" alt="barcode"   />';
                    
                @endphp
            </div>

        </div>
        {{--        <div class="row"> --}}
        {{--            <div class="col-md-12" style="font-size: 8px; margin-top: 5px;"><span --}}
        {{--                    class="centered"> www.colourful.com.bd </span></div> --}}
        {{--        </div> --}}
        <div class="row">
            <div class="col-md-12">
                <span class="centered" style="font-size: 8px;    white-space: pre-line;">
                    {!! getSetting('sale_footer') !!}
                    {{--                    <strong>Note:</strong> Products can be exchange withing 6 days</span> --}}
            </div>
            {{--            <div class="col-md-12"><span class="centered" --}}
            {{--                                         style="font-size: 8px;">NEW SELL --}}
            {{--                                                    CUSTOMER COPY </span></div> --}}
        </div>
    </div>
</div>
