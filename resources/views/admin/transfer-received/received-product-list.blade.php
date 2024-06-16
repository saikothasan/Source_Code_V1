@extends('layouts.app')
@section('title', 'View Received Products')
@section('content')
    <style>
        .header {
            color: rgb(2, 2, 2);
        }

        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .groupedInput {
            border: 1px solid #e1cdcd;
            border-radius: 7px;
            /*border-radius: 10px;*/
        }

        .spacer {
            margin-top: 20px;
        }

        .groupedLabel {
            margin-top: 7px;
            color: rgb(153, 153, 153);
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            font-family: 'Roboto Light';
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }

        .received-pending {
            border: 2px solid green;
            background: none;
        }

        .reject-pending {
            border: 2px solid red;
            background: none;
        }

        .received {
            border: 2px solid green;
            background: green;
            width: 41%;
            color: white;
        }

        .reject {
            border: 2px solid green;
            background: red;
            width: 31%;
            color: white;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h3 class="header">{{translate('View')}} {{translate('Received')}} {{translate('Products')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 spacer" style="overflow-x: auto" >
                    <table class="table table-striped table-responsive example-table">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>{{translate('Transfer')}} {{translate('No')}}.</th>
                                <th>{{translate('Sender')}}</th>
                                <th>{{translate('Sending')}} {{translate('Date')}} {{translate('&')}} {{translate('Time')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($receivedProducts as $value)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $value->invoice_code }}</td>
                                    <td>
                                        @if (collect($value->sendUser->roles)->pluck('name')->contains('Supplier'))
                                            {{ $value->sendUser->name }} ({{transate('Supplier')}})
                                        @else
                                            {{ $value->sendBranch->name }}
                                        @endif
                                    </td>
                                    <td>{{ date('d F Y h:i A', strtotime($value->created_at)) }}</td>
                                    <td class="action">
                                        <div style="display: flex; align-items: baseline;justify-content: space-evenly;">
                                            @if ($value->invoice_type === 1 && $value->status === 0)
                                                <form action="{{ route('received-product.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="transfer_receive_id"
                                                        value="{{ $value->id }}">
                                                    <input type="hidden" name="receive_type" value="received">
                                                    <button type="submit" class="btn btn-block btn-success btn-sm">
                                                        Received
                                                    </button>
                                                </form>
                                            @elseif($value->invoice_type === 2 && $value->status === 1)
                                                <button type="button" class="btn btn-block received">Received</button>
                                            @endif

                                            @if ($value->invoice_type === 1 && $value->status === 0)
                                                <form action="{{ route('received-product.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="transfer_receive_id"
                                                        value="{{ $value->id }}">
                                                    <input type="hidden" name="receive_type" value="reject">
                                                    <button type="submit" class="btn btn-block btn-danger btn-sm">
                                                        {{translate('Reject')}}
                                                    </button>
                                                </form>
                                            @endif

                                            @if ($value->status === 2)
                                                <button style="width: 33%;" type="button"
                                                    class="btn btn-block reject-pending">{{translate('Rejected')}}
                                                </button>
                                            @endif


                                            @if ($value->invoice_type === 1)
                                                <a href="{{ route('received-product.show', $value->id) }}" target="_blank">
                                                    <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" />
                                                </a>
                                            @else
                                                <a href="{{ route('received-product.show', $value->id) }}" target="_blank">
                                                    <img class="image-size" src="{{ asset('images/sales/02.png') }}"
                                                        alt="edit" />
                                                </a>
                                            @endif
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="9">
                                        <h4 class="font-weight-bold">{{translate('No')}} {{translate('Received')}} {{translate('Available')}}</h4>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection

@push('js')
    <script>
        @if (Session::has('received'))

            window.open("{{ route('received-product.show', Session::get('received')) }}", '_blank');
        @endif
    </script>
@endpush
