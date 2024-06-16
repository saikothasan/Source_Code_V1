<div class="content-wrapper" id="print" style="min-height: 282px;">
    <div class="ticket invoice invoice-font invoice-border" style="margin: auto;">
        <div class="text-center">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(getSetting('print_logo', 'images/logoheader.png')))) }}"
                alt="" class="image">
        </div>
        <h3 class="centered">
            <strong>{{ strtoupper($transferMoney->paymentMethod->name ?? '') }} TRANSFER</strong>
        </h3>
        <p class="text-left"> Payment Method: {{ $transferMoney->paymentMethod->name ?? '' }} </p>
        <p class="text-left"> {{ $transferMoney->bank->name ?? '' }} </p>
        <p class="text-left"> {{ $transferMoney->cashDrawer->name ?? '' }} </p>
        @if ($transferMoney->bank != null)
            <p class="text-left"> Account No: {{ $transferMoney->bank->account_no ?? '' }} </p>
        @endif
        <p class="text-left"> BDT {{ $transferMoney->transfer_amount }}  {{get_settings('currency_symbol')}} </p>
        <p class="text-left"> Send By {{ $transferMoney->branch->name ?? '' }}</p>
        <p class="text-left"> {{ $transferMoney->created_at->format('d  F  Y') }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $transferMoney->created_at->format('h:i:s A') }}</p>
    </div>
    <br class="hidden-print" />
    <div class="row">
        <button onclick='printDiv("print")' class="hidden-print">Print</button>
    </div>
</div>
