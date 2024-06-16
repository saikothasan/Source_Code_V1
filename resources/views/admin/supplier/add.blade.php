@extends('layouts.app')
@section('title', 'New supplier add')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{ translate('Dashboard') }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('suppliers.index') }}"><i class="fa fa-group"></i> {{ translate('Suppliers') }}</a></li>
                <li class="active">{{ translate('New') }} {{ translate('supplier') }}</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Content Header (supplier header) -->
                    <div class="box box-danger box-solid">
                        <div class="col-md-">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ translate('New') }} {{ translate('supplier') }}</h3>
                                <div class="box-tools pull-right">
                                    <a href="{{ route('suppliers.index') }}" class="btn btn-sm bg-green"><i
                                            class="fa fa-list"></i> {{ translate('Supplier') }} {{ translate('list') }}</a>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <br>
                            @include('includes.errormessage')
                            <form action="{{ route('suppliers.store') }}" method="POST" class="form-horizontal"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Name') }}</label>
                                    <div class="col-sm-9">
                                        <input name="name" placeholder="name" class="form-control" required=""
                                            type="text" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('E-mail') }}
                                        {{ translate('Address') }}</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" placeholder="E-mail Address"
                                            name="email" value="{{ old('email') }}">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Phone') }}</label>
                                    <div class="col-sm-9">
                                        <input name="phone" placeholder="Phone" class="form-control" required=""
                                            type="text" value="{{ old('phone') }}" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Area') }}</label>
                                    <div class="col-sm-9">
                                        <input name="area" placeholder="area" class="form-control" type="text"
                                            value="{{ old('area') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Address') }}</label>
                                    <div class="col-sm-9">
                                        <textarea name="address" rows="3" class="form-control" placeholder="Address" style="resize: vertical;">{{ old('address') }}</textarea>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Company') }}</label>
                                    <div class="col-sm-9">
                                        <input name="company" placeholder="Company" class="form-control" type="text"
                                            value="{{ old('company') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Company') }}
                                        {{ translate('phone') }}</label>
                                    <div class="col-sm-9">
                                        <input name="company_phone" placeholder="Company phone" class="form-control"
                                            type="text" value="{{ old('company_phone') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Previous') }}
                                        {{ translate('Due') }}</label>
                                    <div class="col-sm-9">
                                        <input name="due" placeholder="Previous Due" class="form-control" type="number"
                                            value="{{ old('due') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Note') }}</label>
                                    <div class="col-sm-9">
                                        <input name="note" placeholder="Note" class="form-control" type="text"
                                            value="{{ old('note') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">{{ translate('Photo') }}</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="photo" onchange="readPicture(this)">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <center>
                                        <img src="//placehold.it/200x200" alt="supplier Photo" id="supplier_photo">
                                        <br> <br>
                                        <button type="reset"
                                            class="btn btn-sm bg-red">{{ translate('Reset') }}</button>
                                        <button type="submit"
                                            class="btn btn-sm bg-green">{{ translate('Save') }}</button>
                                    </center>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // profile picture change
    function readPicture(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#supplier_photo')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
