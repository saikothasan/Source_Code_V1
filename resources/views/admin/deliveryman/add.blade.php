@extends('layouts.app')
@section('title', 'New Delivery Man Add')
@section('content')
    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-12 row">
                    <div class="col-md-12 text-center">
                        <h1>Add Delivery Man</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="box-body">
                        <br>
                        <form action="{{ route('delivery-man.store') }}" method="POST" class="form-horizontal"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="name" placeholder="Name" class="form-control"  type="text"
                                           value="{{ old('name') }}" autocomplete="off">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="phone" placeholder="Phone" class="form-control"
                                           type="number" value="{{ old('Phone') }}" autocomplete="off">
                                    @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="nid" placeholder="NID" class="form-control"  type="number"
                                           value="{{ old('nid') }}" autocomplete="off">
                                    @error('nid')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="delivery_charge" placeholder="Delivery Charge" class="form-control"
                                            type="number" value="{{ old('delivery_charge') }}"
                                           autocomplete="off">
                                    @error('delivery_charge')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-sm-12">
                                    <textarea name="address" rows="3" placeholder="Address" class="form-control"
                                               autocomplete="off">{{ old('address') }}</textarea>
                                    @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="delivery_area" rows="3" placeholder="Delivery Area"
                                              class="form-control"
                                              autocomplete="off">{{ old('delivery_area') }}</textarea>
                                    @error('delivery_area')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" name="photo" onchange="readPicture(this)">
                                    @error('photo')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <img src="//placehold.it/200x200" alt="employee Photo" id="employee_photo">
                                    <br> <br>
                                    <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                    <button type="submit" class="btn btn-sm bg-green">Save</button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
@endsection

@section('footerSection')
    <script>
        // profile picture change
        function readPicture(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#employee_photo')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $('#join_date').datepicker({
                autoclose: true,
                changeYear: true,
                changeMonth: true,
                dateFormat: "dd-mm-yy",
                yearRange: "-10:+10"
            });
        });
    </script>
@endsection
