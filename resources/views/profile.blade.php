@extends('layouts.app')
@section('title', 'User profile')
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
        </style>
    @endpush
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row">
                <div class="col-md-12 row">
                    <div class="col-md-12 text-center">
                        <h1>{{ translate('Update') }} {{ translate('Profile') }}</h1>
                    </div>
                </div>
            </div>
            <br />
        </section>
        <div class="row text-center">
            <div class="col-md-4"></div>
            <div class="col-md-4 ">
                <form action="{{ route('profile.update') }}" class="form-horizontal  text-center"
                    enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control" placeholder="{{ translate('Name') }}" name="id"
                                value="{{ $user_info->id }}">
                            <input type="text" class="form-control" placeholder="{{ translate('Name') }}" name="name"
                                value="{{ $user_info->name }}">
                        </div>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="{{ translate('Username') }}"
                                name="username" value="{{ $user_info->username }}">
                        </div>
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="email" class="form-control" placeholder="{{ translate('Email') }}"
                                name="email" value="{{ $user_info->email }}">
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="{{ translate('Phone') }}"
                                name="phone" value="{{ $user_info->phone }}">
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group ">
                        <div class="col-sm-12">
                            <center>
                                <textarea class="form-control text-center" name="address" placeholder="{{ translate('Address') }}"
                                    style="resize: vertical;">{{ $user_info->address }}</textarea>
                            </center>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" placeholder="{{translate('Password')}}" name="password">
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div class="form-group image">

                        @if ($user_info->photo)
                            <img src="{{ asset($user_info->photo) }}" alt="" id="supplier_photo">
                        @else
                            <img src="{{ asset('images/blank.jpg') }}" alt="" id="supplier_photo">
                        @endif
                        <div class="col-sm-12">
                            <input type="file" name="photo" onchange="readPicture(this)">
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">{{ translate('Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>

        </div>
    </div>
@endsection
<script>
    // profile picture change
    function readPicture(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#user_photo')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
