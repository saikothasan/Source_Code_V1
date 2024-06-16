@extends('layouts.app')
@section('title', 'Update Delivery Man')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 row">
                <div class="col-md-12 text-center">
                    <h1>Update Delivery Man</h1>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <form action="{{ route('delivery-man.update', $delivery_man->id) }}" method="POST"
                              class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="name" placeholder="Name" class="form-control" required="" type="text"
                                           value="{{ old('name', $delivery_man->name) }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="phone" placeholder="Phone" class="form-control" required=""
                                           type="number" value="{{ old('Phone', $delivery_man->phone) }}"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="nid" placeholder="NID" class="form-control" required="" type="number"
                                           value="{{ old('nid', $delivery_man->nid) }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input name="delivery_charge" placeholder="Delivery Charge" class="form-control"
                                           required="" type="number"
                                           value="{{ old('delivery_charge', $delivery_man->delivery_charge) }}"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-sm-12">
                                    <center>
                                        <textarea name="address" rows="3" placeholder="Address" class="form-control"
                                                  required=""
                                                  autocomplete="off">{{ old('address', $delivery_man->address) }}</textarea>
                                    </center>
                                </div>

                            </div>
                            <div class="form-group">

                                <div class="col-sm-12">
                                    <center>
                                        <textarea name="delivery_area" rows="3" placeholder="Address"
                                                  class="form-control" required=""
                                                  autocomplete="off">{{ old('delivery_area', $delivery_man->delivery_area) }}</textarea>
                                    </center>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" class="form-control" name="photo" onchange="readPicture(this)">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <center>
                                    <img src="{{ asset($delivery_man->photo) }}" alt="employee Photo"
                                         id="employee_photo" height="100" width="200">
                                    <br> <br>
                                    <button type="reset" class="btn btn-sm bg-red">Reset</button>
                                    <button type="submit" class="btn btn-sm bg-green">Save</button>
                                </center>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
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
