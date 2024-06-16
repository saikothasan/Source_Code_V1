@extends('layouts.app')
@section('title', $report['report_name'] . ' ' . $report['report_id'])
@section('content')
    <style>
        .corner {
            border-radius: 7px;
            text-align: center;
        }

        .spacer {
            margin-top: 20px;
        }

        .example-table tr:nth-child(2n+1) {
            background-color: #ddd;
        }

        .example-table tr:nth-child(2n+0) {
            background-color: #eee;
        }

        .action {
            color: rgb(167, 169, 172);
            /* font-family: 'Roboto Light'; */
        }

        .button-size {
            padding: 2px 13px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .custom-btn {
            position: relative;
        }

        .custom-add {
            position: absolute;
            top: 0;
            border-radius: 5px;
            right: 35px;
            z-index: 9;
            border: none;
            top: 2px;
            height: 30px;
            cursor: pointer;
            color: #423030;
            background-color: transparent;
            transform: translateX(2px);
        }

        .font {
            font-family: 'Roboto Light';
        }

        .custom-home {
            padding: 8px 59px;
            font-size: 18px;
            line-height: 1.3333333;
        }

        .image-size {
            width: 1.5em;
            height: 1.5em;
        }
    </style>
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard" id="print-report">
                <div class="container" id="report-print">

                </div>
            </div>

            <div class="text-center" style="margin: 2%;">
                <button onclick='printDiv("report-print")' class="btn text-black print pointer hidden-print"
                    style=" margin-right:20px; color: black;border-color: #000000;background: white;">Print</button>
                <a href="{{ route('report.download', $report['id']) }}" class="btn text-black print pointer hidden-print"
                    style=" margin-right:20px; color: black;border-color: #000000;background: white;">Download</a>
            </div>
        </section>

    </div>
@endsection

@push('js')
    <script>
        async function getReport() {
            preLoader(true);
            await $.ajax({
                url: "{{ route('report-history.get', $report->id) }}",
                type: "GET",
                success: function(data) {
                    $("#report-print").html(data);
                    preLoader(false);
                }
            })
        }
        $(document).ready(function() {
            getReport()
        });
    </script>
@endpush
