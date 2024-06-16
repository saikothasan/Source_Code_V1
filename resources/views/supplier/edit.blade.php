@extends('layouts.app')
@section('title', 'update Supplier')
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

            :-moz-placeholder { /* Firefox 18- */
                text-align: center;
            }

            ::-moz-placeholder { /* Firefox 19+ */
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


        </style>
    @endpush
    <div class="content-wrapper">

        <div class="content supplier_content">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <h2><strong> Update Supplier </strong></h2>
                    <span>{{ date('Y-m-d') }}</span>
                    <form class="form-horizontal" action="{{route('suppliers.update',$supplier_info->id)}}"
                          method="POST" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="name" class="form-control" id=""
                                           value="{{ old('name',$supplier_info->name) }}" placeholder="Supplier Name">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="company" class="form-control"
                                           value="{{ old('company',$supplier_info->company) }}" id=""
                                           placeholder="Company Name">
                                    @error('company')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="owner_name" class="form-control"
                                           value="{{ old('owner_name',$supplier_info->owner_name) }}" id=""
                                           placeholder="Owner Name">
                                    @error('owner_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone',$supplier_info->phone) }}" id=""
                                           placeholder="Phone Number">
                                    @error('phone')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="email" class="form-control"
                                           value="{{ old('email',$supplier_info->email) }}" id=""
                                           placeholder="Email Address">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="address"
                                           value="{{ old('address',$supplier_info->address) }}" class="form-control"
                                           id="" placeholder="Address">
                                    @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group">
                              <div class="col-sm-6">
                                <input type="text" name="email" value="{{ old('email',$supplier_info->email) }}" class="form-control" id="" placeholder="User Id : Email Address Default ">
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                              </div>
                              <div class="col-sm-6">
                                  <input type="text" name="password" value="{{ old('password') }}"  class="form-control" id="" placeholder="Password">
                                  @error('password')
                                  <span class="text-danger">{{$message}}</span>
                                  @enderror
                                <P style="font-size: 10px">Minimum 6 Digit</P>
                                </div>
                            </div> --}}
                            <div class="form-group image">
                                @if($supplier_info->photo)
                                    <img src="{{asset($supplier_info->photo) }}" alt="" id="supplier_photo">

                                @else
                                    <img src="{{ asset('images/blank.jpg') }}" alt="" id="supplier_photo">

                                @endif
                                <div class="col-sm-12">
                                    <input type="file" name="photo" onchange="readPicture(this)">
                                </div>
                            </div>
                        </div>
                        <div class="row text-center form-group mt-5">
                            <div class="col-md-4">
                                <a href="{{ route('suppliers.index') }}">
                                    <button type="button" class="btn btn-primary">View Supplier</button>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success">Update</button>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // profile picture change
        function readPicture(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
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
