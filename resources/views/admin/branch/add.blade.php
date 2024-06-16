@extends('layouts.app')
@section('title', 'New Branch Create')
@push('css')
    <style>
        .mt-5 {
            margin-top: 10%;
        }

        .time-form {
            height: 35px;
        }

        .color-gray {
            color: #bbbdbf;
        }
        @media only screen and (max-width: 768px) {
            .buttons button {
                width: 100%;
                margin: 5px 0px;
            }
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
                            <h1>{{ translate('Add') }} {{ translate('New') }} {{ translate('Branch') }}</h1>
                        </div>
                    </div>
                </div>
                <br />
                <div class="text-center row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form role="form" method="POST" action="{{ route('branch.store') }}">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="name" class="form-control rounded"
                                        value="{{ old('name') }}"
                                        placeholder="{{ translate('Branch') }} {{ translate('Name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input type="text" name="branch_id"
                                        value="{{ old('branch_id', rand(0, 100000000)) }}" class="form-control rounded"
                                        placeholder="{{ translate('Branch') }} {{ translate('Id') }}">
                                    @error('branch_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="text" name="phone_number" class="form-control rounded"
                                        placeholder="{{ translate('Phone') }} {{ translate('Number') }}"
                                        value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="address" class="form-control rounded"
                                        value="{{ old('address') }}" placeholder="{{ translate('Location') }}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="form-group col-md-12 ">
                                    <div class="form-control rounded" style="min-height:50px;display:flex">
                                        <div class="form-group col-md-3" style="padding-top: 7px;">{{translate('Branch')}} {{translate('Hour')}}</div>
                                        <div class="form-group col-md-3">
                                            <input type="time" class="form-control rounded time-form" id="start_time"
                                                name="open_time" placeholder="{{translate('Opening')}} {{translate('Hour')}}" value="{{ old('open_time') }}">
                                            @error('open_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="time" class="form-control rounded time-form" id="end_time"
                                                name="close_time" value="{{ old('close_time') }}"
                                                placeholder="{{translate('Branch')}} {{translate('Hour')}}">
                                            @error('close_time')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-3" readonly style="padding-top: 7px;"><input
                                                style="border: none;width: 100%;" type="text" id="diff"
                                                value="06 Hour"></div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="form-group">

                                <select class="form-control select2" name="weekend[]" multiple="multiple"
                                    data-placeholder="{{translate('Select')}} {{translate('Weekend')}}" style="width: 100%;">
                                    @foreach (getWeekendName() as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ collect(old('weekend'))->contains($key) ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('weekend')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <div class="form-group">

                                <select class="form-control" name="status">
                                    <option value="1">{{ translate('Active') }}</option>
                                    <option value="0">{{ translate('Inactive') }}</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6" style="padding-left: 0px">
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                        placeholder="{{ translate('Email') }} {{ translate('Address') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-group col-md-6">
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="{{ translate('Password') }}">
                                    <span class="input-group-addon" onclick="passWordShow()"><i id="icon"
                                            class="fa fa-eye"></i></span>
                                </div>
                                <small>{{ translate('Minimum') }} 6 {{ translate('Digit') }}</small>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <select name="permission_id[]"
                                    data-placeholder="{{ translate('Select') }} {{ translate('Permission') }}"
                                    class="form-control select2" id="" style="width: 100%;" multiple>
                                    @foreach ($permissions as $key => $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center color-gray " style="margin-top: 3%;">
                                    <div class="col-md-4">{{ translate('Creator') }}</div>
                                    <div class="col-md-6">
                                        <span>{{ auth()->user()->name }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row text-center form-group mt-5 buttons">
                                <div class="col-md-4">
                                    <a href="{{ route('branch.index') }}">
                                        <button type="button" class="btn btn-primary">{{ translate('View') }}
                                            {{ translate('Branch') }}</button>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success">{{ translate('Submit') }}</button>

                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('home') }}">
                                        <button type="button" class="btn  btn-primary">{{ translate('Home') }}</button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </section>
    </div>




@endsection
@push('js')
    <script>
        $('.select2').change(function() {
            let values = $('.select2').val();
            if (values && values.includes('0')) {
                if (values.length > 1) {
                    $('.select2').val(null);
                }
            }
        })
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

                    return (hours < 9 ? "0" : "") + hours + ":" + (minutes < 9 ? "0" : "") + minutes;
                }

                let hello = diff(start, end);
                $("#diff").val(hello);

            });

        });

        function passWordShow() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            $("#icon").toggleClass("fa-eye-slash");
        }
    </script>
@endpush
