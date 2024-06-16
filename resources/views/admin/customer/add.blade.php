@extends('layouts.app')
@section('title', 'New customer add')
@section('content')
    @push('css')
        <style>
            .mt-5 {
                margin-top: 10%;
            }

            .color-gray {
                color: #bbbdbf;
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <section class="content">
            <div class="dashboard">
                <div class="row">
                    <div class="col-md-12 row">
                        <div class="col-md-12 text-center">
                            <h1><strong>{{translate('Add')}} {{translate('Customer')}} {{translate('Information')}}</strong></h1>
                            <p class="color-gray">{{ date('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-center row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form role="form" method="POST" action="{{ route('customers.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="phone" class="form-control rounded"
                                        value="{{ old('phone') }}" placeholder="Phone Number">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control rounded" placeholder="{{translate('Customer')}} {{translate('Name')}}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="text" name="district_id" class="form-control rounded"
                                        placeholder="{{translate('District')}}" value="{{ old('district_id') }}">
                                    @error('district_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="text" name="zip_code" class="form-control rounded"
                                        placeholder="{{translate('Zip')}} {{translate('Code')}}" value="{{ old('zip_code') }}">
                                    @error('zip_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="address" class="form-control rounded"
                                        value="{{ old('address') }}" placeholder="{{translate('Address')}}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="date" name="date_of_birth" class="form-control rounded"
                                        value="{{ old('date_of_birth') }}" placeholder="{{translate('Date Of Birth')}}">
                                    @error('date_of_birth')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="email" value="{{ old('email') }}"
                                        class="form-control" placeholder="{{translate('Email')}}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input type="text" name="facebook_id" value="{{ old('facebook_id') }}"
                                        class="form-control" placeholder="{{translate('Facebook')}}">
                                    @error('facebook_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group  image">
                                    <img src="{{ asset('images/blank.jpg') }}" alt="" id="supplier_photo">
                                    <div class="col-sm-12">
                                        <input type="file" name="photo" onchange="readPicture(this)">
                                    </div>
                                    @error('photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="row text-center form-group mt-5">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-info">{{translate('Add')}} {{translate('Customer')}}</button>
                                    </div>
                                    <div class="col-md-4">
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

<script>
    // profile picture change
    function readPicture(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#customer_photo')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(200);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
