@extends('layouts.app')
@section('title', 'Branch Update')
@push('css')
    <style>
        .cl-custom-check-label {
            padding-right: 5px;
        }

        .mt-5 {
            margin-top: 10%;
        }

        .time-form {
            height: 35px;
        }

        .color-gray {
            color: #bbbdbf;
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h1>Update BRANCH</h1>
                            <p class="color-gray">{{ date('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @endif
                <div class="text-center row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form role="form" method="POST" action="{{ route('branch.update', $branch->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="name" class="form-control rounded"
                                        value="{{ old('name', $branch->name) }}" placeholder="Branch Name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" name="branch_id"
                                        value="{{ old('branch_id', $branch->branch_id) }}" class="form-control rounded"
                                        placeholder="Branch Id">
                                    @error('branch_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="text" name="phone_number" class="form-control rounded"
                                        placeholder="Phone Number" value="{{ old('phone_number', $branch->phone_number) }}">
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="address" class="form-control rounded"
                                        value="{{ old('address', $branch->address) }}" placeholder="Location">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 ">
                                    <div class="form-control rounded" style="height: 49px;">
                                        <div class="form-group col-md-3" style="padding-top: 7px;">Branch Hour</div>
                                        <div class="form-group col-md-3">
                                            <input type="time" class="form-control rounded time-form" name="open_time"
                                                id="start_time" placeholder="Branch Hour"
                                                value="{{ old('open_time', $branch->open_time) }}">
                                            @error('open_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="time" class="form-control rounded time-form" name="close_time"
                                                id="end_time" value="{{ old('close_time', $branch->close_time) }}"
                                                placeholder="Branch Hour">
                                            @error('close_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3" style="padding-top: 7px;"> <input
                                                style="border: none;" type="text" id="diff" value="06 Hour"> </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">

                                <select class="form-control select2" name="weekend[]" multiple="multiple"
                                    data-placeholder="Select Weekend" style="width: 100%;">
                                    @foreach (getWeekendName() as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ collect($branch->weekend)->contains($key) ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('weekend')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">

                                <select class="form-control" name="status">
                                    <option {{ $branch->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ $branch->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center color-gray " style="margin-top: 3%;">
                                    <div class="col-md-4">Creator</div>
                                    <div class="col-md-6"><input disabled type="text" value="{{ auth()->user()->name }}"
                                            style="border-radius: 7px;" placeholder="User Name" /></div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>


                            {{--                                    <div class="row"> --}}
                            {{--                                        <div class="form-group col-md-6"> --}}
                            {{--                                            <input type="text" class="form-control" --}}
                            {{--                                                   placeholder="User Id : Email Address Default"> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="form-group col-md-6"> --}}
                            {{--                                            <input type="text" class="form-control" placeholder="Password"> --}}
                            {{--                                            <small>Minimum 6 Digit</small> --}}
                            {{--                                        </div> --}}
                            {{--                                    </div> --}}
                            {{--                                    <div class="row form-group"> --}}
                            {{--                                        <div class="col-md-4"></div> --}}
                            {{--                                        <div class="col-md-4 text-center"> --}}
                            {{--                                            <div class="col-md-6">Creator</div> --}}
                            {{--                                            <div class="col-md-6"><input type="text" placeholder="User Name" /></div> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col-md-4"></div> --}}
                            {{--                                    </div> --}}
                            {{--                                    <div class="form-group"> --}}
                            {{--                                        <button type="submit" class="btn" style="background-color: rgb(255,104,0);border-color: rgb(255,104,0)">Verify</button> --}}
                            {{--                                    </div> --}}
                            {{--                                    <div class="row text-center form-group"> --}}
                            {{--                                        <div class="col-md-4 form-group"></div> --}}
                            {{--                                        <div class="col-md-4 form-group"> --}}
                            {{--                                            <input class="form-control" placeholder="Confirmation Code"> --}}
                            {{--                                            <span>see your admin mail box</span> --}}
                            {{--                                        </div> --}}
                            {{--                                        <div class="col-md-4 form-group"></div> --}}
                            {{--                                    </div> --}}

                            <div class="row text-center form-group mt-5">
                                <div class="col-md-4">
                                    <a href="{{ route('branch.index') }}">
                                        <button type="button" class="btn btn-primary">View Branch </button>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">Update</button>

                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('home') }}">
                                        <button type="button" class="btn  btn-primary">Home</button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
    </div>
    </div>
    </section>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $("#end_time").change(function() {

                var start = document.getElementById("start_time").value;
                var end = document.getElementById("end_time").value;


                function diff(start, end) {
                    start = start.split(":");
                    end = end.split(":");
                    var startDate = new Date(0, 0, 0, start[0], start[1], 0);
                    var endDate = new Date(0, 0, 0, end[0], end[1], 0);
                    var diff = endDate.getTime() - startDate.getTime();
                    var hours = Math.floor(diff / 1000 / 60 / 60);
                    diff -= hours * 1000 * 60 * 60;
                    var minutes = Math.floor(diff / 1000 / 60);

                    return (hours < 9 ? "0" : "") + hours + ":" + (minutes < 9 ? "0" : "") + minutes +
                        " Hour";
                }

                let hello = diff(start, end);
                $("#diff").val(hello);

            });

            var start = document.getElementById("start_time").value;
            var end = document.getElementById("end_time").value;


            function diff(start, end) {
                start = start.split(":");
                end = end.split(":");
                var startDate = new Date(0, 0, 0, start[0], start[1], 0);
                var endDate = new Date(0, 0, 0, end[0], end[1], 0);
                var diff = endDate.getTime() - startDate.getTime();
                var hours = Math.floor(diff / 1000 / 60 / 60);
                diff -= hours * 1000 * 60 * 60;
                var minutes = Math.floor(diff / 1000 / 60);

                return (hours < 9 ? "0" : "") + hours + ":" + (minutes < 9 ? "0" : "") + minutes + " Hour";
            }
            let hello = diff(start, end);
            $("#diff").val(hello);
        });
    </script>
@endpush
