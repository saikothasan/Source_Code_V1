@extends('layouts.app')
@section('title', 'Payment Method')
@section('content')
    <style>
        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .small-box {
            border-radius: 10px;
        }

        .small-box:hover {
            text-decoration: none;
            color: #000;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-center">
                            <h3><strong>Transfer History</strong></h3>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <br />
                    <br />
                    <form action="" method="get">
                        <div class="col-md-12 row text-center spacer">

                            <div class="col-md-8 row">
                                <div class="form-control">
                                    <div class="col-md-2 text-center text-color">
                                        From
                                    </div>
                                    <div class="col-md-4 ">
                                        <input type="date" class="form-control" id="" name="from_date"
                                            value="">
                                    </div>
                                    <div class="col-md-2 text-center text-color">To</div>
                                    <div class="col-md-4">
                                        <input type="date" class="form-control" value="" name="to_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="width: 72px;">
                                    <x-url-param-clear></x-url-param-clear>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="width: 72px;">
                                    <button class="form-control">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br />
                    <br />
                    <br />
                    <div class="card-body p-0 spacer" style="overflow-x: auto" >
                        <table class="table table-striped table-responsive example-table">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Receiver</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bankTransfers as $value)
                                    <tr>
                                        <td>{{ serialNumber($bankTransfers, $loop) }}</td>
                                        <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                                        <td>{{ $value->receive_type }}</td>
                                        <td>{{ $value->bank->name ?? '' }}
                                            {{ $value->bank_account_no ?? $value->cashDrawer->name }}</td>
                                        <td>{{ $value->bankTransfer->reference_id ?? '' }}</td>
                                        <td>{{ floatFormat($value->transfer_amount) }}</td>
                                        <td>{{ $value->money_transfer_status }}</td>
                                    </tr>
                                @empty
                                    <td>No History </td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $bankTransfers->withQueryString()->links() }}
                        <br />
                        <div class="row text-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <a href="{{ route('payment-method.index') }}">
                                    <button class="btn btn-info">Payment Method</button>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('transfer-money.create') }}">
                                    <button class="btn btn-success">Money Transfer</button>
                                </a>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

@endsection
