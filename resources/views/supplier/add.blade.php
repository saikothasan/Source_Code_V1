@extends('layouts.app')
@section('title', 'New Supplier')
@section('content')

    @push('css')
        <style>
            .supplier_content {
                text-align: center;
            }

            .form-control {
                border-radius: 7px;
                box-shadow: none;
                border-color: #06cdffd6 !important;
                height: 50px;
            }


            ::-webkit-input-placeholder {
                text-align: center;
            }

            :-moz-placeholder {
                /* Firefox 18- */
                text-align: center;
            }

            ::-moz-placeholder {
                /* Firefox 19+ */
                text-align: center;
            }

            :-ms-input-placeholder {
                text-align: center;
            }

            .image img {
                width: 102px;
                border-radius: 50px;
            }

            .image input {
                margin-left: 37%;
                margin-top: 23px;
            }

            @media only screen and (max-width: 768px) {
                .buttons button {
                    width: 100%;
                    margin-bottom: 5px;
                }
            }
        </style>
    @endpush
    <div class="content-wrapper">
        <div class="content supplier_content">
            <div class="row">
                <div class="col-lg-4 col-md-3"></div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <h2><strong style="text-transform:uppercase"> {{ translate('Add') }} {{ translate('New') }}
                            {{ translate('Suppliers') }} </strong></h2>
                    <form class="form-horizontal" action="{{ route('suppliers.store') }}" method="POST" class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="name" class="form-control" id=""
                                        value="{{ old('name') }}"
                                        placeholder="{{ translate('Supplier') }} {{ translate('Name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="company" class="form-control" value="{{ old('company') }}"
                                        id="" placeholder="{{ translate('Company') }} {{ translate('Name') }}">
                                    @error('company')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="owner_name" class="form-control"
                                        value="{{ old('owner_name') }}" id=""
                                        placeholder="{{ translate('Owner') }} {{ translate('Name') }}">
                                    @error('owner_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                        id="" placeholder="{{ translate('Phone') }} {{ translate('Number') }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                        id="" placeholder="{{ translate('Address') }}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                        id="" placeholder="{{ translate('Email') }} {{ translate('Address') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control" id="" placeholder="{{ translate('Password') }}">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <P style="font-size: 10px">{{ translate('Minimum') }} 6 {{ translate('Digit') }}</P>
                                </div>
                            </div>
                            {{-- <div class="form-group image">
                                <img src="{{ asset('images/blank.jpg') }}" alt="" id="supplier_photo">
                                <div class="col-sm-12">
                                    <input type="file" name="photo" onchange="readPicture(this)">
                                </div>
                            </div> --}}
                        </div>
                        <div class="row text-center form-group mt-5 buttons">
                            <div class="col-md-5 col-xs-12">
                                <a href="{{ route('suppliers.index') }}">
                                    <button type="button" class="btn btn-primary">{{ translate('View') }}
                                        {{ translate('Supplier') }}</button>
                                </a>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <button type="submit" class="btn btn-success">{{ translate('Submit') }}</button>

                            </div>
                            <div class="col-md-3 col-xs-12">
                                <a href="{{ route('home') }}">
                                    <button type="button" class="btn  btn-primary">{{ translate('Home') }}</button>
                                </a>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-3"></div>
        </div>
    </div>
@endsection
@push('js')
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
@endpush
