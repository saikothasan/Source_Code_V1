<div class="content-wrapper" id="print" style="min-height: 282px;">
    <div class="ticket invoice invoice-font invoice-border" style="margin: auto;">
        <div class="text-center">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(asset(getSetting('print_logo', 'images/logoheader.png')))) }}"
                alt="" class="image">
        </div>
        <h3 class="centered">
            <strong>TRANSFER</strong> CASH
        </h3>
        <p class="text-left"> {{ $cashHistory->branch->name ?? '' }} </p>
        @if ($cashHistory->payment_reference != null)
            <p class="text-left"> Account No {{ $cashHistory->payment_reference }} </p>
        @else
            <p class="text-left"> Cash Drawer </p>
        @endif
        <p class="text-left"> {{ $cashHistory->amount }} BDT </p>
        <p class="text-left"> Sender( {{ $cashHistory->sender->name ?? '' }})</p>
        <p class="text-left"> {{ $cashHistory->note }} </p>
        <p class="text-left"> {{ $cashHistory->created_at->format('d  F  Y') }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $cashHistory->created_at->format('h:i:s A') }}</p>
    </div>
    <br class="hidden-print" />
    <div class="row">
        <button onclick='printDiv("print")' class="hidden-print">Print</button>
    </div>
</div>
